<?php

class Opiniones extends ActiveRecord
{
    public function getOpiniones()
    {
        return $this->find("order: id desc");
    }
}
