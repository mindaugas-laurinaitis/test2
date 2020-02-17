<?php


namespace App\Traits;


trait JsonSerializeTrait
{
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $data = [];

        foreach ($this as $key => $value) {
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d h:m:s');
            }
            $data[$key] = $value;
        }

        return $data;
    }

}