<?php

namespace Rnr\JsonSchemaRequest;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class DataPreparator
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function prepare($data)
    {
        if (is_object($data)) {
            foreach ((array) $data as $key => $value) {
                $data->{$key} = $this->prepare($value);
            }
        }

        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $value = $this->prepare($value);
            }

            $data = ($this->isVector($data)) ? ($data) : ((object) $data);
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function isVector(array $data): bool
    {
        return $data === array_values($data);
    }
}
