<?php
namespace Cookies\Model;

class Storage
{
    private $a;
    private $b;
    private $countA = 0;
    private $countB = 0;

    public function __construct()
    {
        $this->a = new \SplMaxHeap();
        $this->b = new \SplMinHeap();
    }

    public function add($d)
    {
        if (($this->countA > 0) && $d > $this->a->top()) {
            $this->b->insert($d);
            $this->countB++;

            if ($this->countA <= $this->countB) {
                $this->a->insert($this->b->extract());

                $this->countA++;
                $this->countB--;
            }
        } else {
            $this->a->insert($d);
            $this->countA++;
            if ($this->countA > ($this->countB + 2)) {
                $this->b->insert($this->a->extract());

                $this->countB++;
                $this->countA--;
            }
        }
    }

    public function get()
    {
        $result = $this->a->extract();
        $this->countA--;

        if ($this->countB > 0 && $this->countA <= $this->countB) {
            $this->a->insert($this->b->extract());

            $this->countA++;
            $this->countB--;
        }

        return $result;
    }
}
