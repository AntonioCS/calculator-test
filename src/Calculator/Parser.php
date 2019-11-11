<?php


namespace App\Calculator;



class Parser
{
    use TraitHelper;

    /**
     * @var Token[]
     */
    private $tokens;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var int
     */
    private $addedWeight = 0;

    /**
     * @var bool
     */
    private $inParen = false;

    /**
     * @var array
     */
    private $operatorWeight = [
        '^' => 3,
        '*' => 2,
        '/' => 2,
        '-' => 1,
        '+' => 1,
        '&' => 1,
        '|' => 1
    ];

    /**
     * @var int
     */
    private $parenWeight = 5;

    /**
     * @var NodeRoot
     */
    private $nodeRoot = null;

    public function __construct()
    {
    }

    public function parse(array $tokensData) : Node
    {
        $this->tokens = $tokensData;
        $this->position = 0;
        $this->addedWeight = 0;
        $this->inParen = 0;
        $currentNode = new Node(null, null);

        /** @var Token $token */
        while ($token = $this->getNextToken()) {
            switch ($token->getTokenType()) {
                case TokenType::NUMBER:
                    if ($currentNode->value === null) {
                        $currentNode->value = $token->getValue();
                    } else {
                        $nodeSearch = $currentNode;
                        $work = true;

                        while ($work) {
                            $work = false;
                            //try to add to furthest left
                            $nodeLeftParent = $this->getFurthestLeftNodeParent($nodeSearch);
                            /*if ($nodeLeftParent->nodeLeft === null) {
                                $currentNode->nodeLeft = new Node($nodeLeftParent, $token->getValue());
                            } else*/
                            if ($nodeLeftParent->nodeRight === null) {
                                $nodeLeftParent->nodeRight = new Node($nodeLeftParent, $token->getValue());
                            } else {
                                if ($nodeLeftParent->parent->nodeRight === null) {
                                    $nodeLeftParent->parent->nodeRight = new Node($nodeLeftParent, $token->getValue());
                                } else {
                                    $work = true;
                                    $nodeSearch = $nodeLeftParent->parent->nodeRight;
                                }
                            }
                        }
                    }
                break;
                case TokenType::OPERATOR:
                    if ($currentNode->value !== null) {
                        $newValue = $token->getValue();
                        $newOperatorNode = new Node(null, $newValue, ($this->operatorWeight[$newValue] ?? 0) + $this->addedWeight);
                        $currentValueWeight = $currentNode->weight;
                        $newOperatorWeight = $newOperatorNode->weight;

                        if ($this->isNodeOperator($currentNode) && $newOperatorWeight > $currentValueWeight) { //swap
                            //$this->debugNode($currentNode);
                            //$this->debugNode($newOperatorNode);
                            $node = $this->fetchHighestNode($currentNode, $newOperatorNode);
                            //$this->debugNode($node);
                            $newOperatorNode->parent = $node;
                            $newOperatorNode->nodeLeft = new Node($newOperatorNode, $node->nodeRight->value);
                            $node->nodeRight->value = $node->nodeLeft->value;
                            $node->nodeLeft = $newOperatorNode;
                        } else {
                            $newOperatorNode->parent = null;
                            $newOperatorNode->nodeLeft = $currentNode;
                            $currentNode->parent = $newOperatorNode;
                            $currentNode = $newOperatorNode;
                        }
                    } else {
                        throw new \Exception('Error 456');
                    }
                break;
                case TokenType::PARENTHESES_OPEN:
                    $this->inParen = true;
                    $this->addedWeight += $this->parenWeight;
                    break;

                case TokenType::PARENTHESES_CLOSE:
                    $this->inParen = false;
                    $this->addedWeight -= $this->parenWeight;
                    break;
            }
        }

        if ($this->inParen) {
            throw new \Exception('Unclosed parentheses');
        }

        return $currentNode;
    }

    private function fetchHighestNode(Node $root, Node $toAdd) : Node
    {
        while ($this->isNodeOperator($root) && $this->isNodeOperator($root->nodeLeft) && $root->nodeLeft->weight < $toAdd->weight) {
            $root = $root->nodeLeft;
        }

        return $root;
    }

    private function isNodeOperator(Node $node) : bool
    {
        return isset($this->operatorWeight[$node->value]);
    }

    private function getNextToken() : ?Token
    {
        if (isset($this->tokens[$this->position])) {
            return $this->tokens[$this->position++];
        }

        return null;
    }

    private function debugNode(Node $node)
    {
        echo "Node value: ", $node->value , "\n",
            "\t Node left value: " , ($node->nodeLeft ? $node->nodeLeft->value : "NONE") , "\n",
            "\t Node right value: "  , ($node->nodeRight ? $node->nodeRight->value : "NONE") , "\n",
            "\t Node weight: " , $node->weight, "\n"
        ;
    }
}
