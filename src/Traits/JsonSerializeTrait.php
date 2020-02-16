<?php


namespace App\Traits;


trait JsonSerializeTrait
{
    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = [];

        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

}