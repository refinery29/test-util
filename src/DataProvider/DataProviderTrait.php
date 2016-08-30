<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

/**
 * @deprecated Use TestTrait instead.
 */
trait DataProviderTrait
{
    /**
     * @param array $values
     *
     * @return \Generator
     */
    protected function provideData(array $values)
    {
        foreach ($values as $key => $value) {
            yield [
                $key => $value,
            ];
        }
    }

    /**
     * @param DataProviderInterface[] ...$dataProviders
     *
     * @return \Generator
     */
    protected function provideDataFrom(...$dataProviders)
    {
        /*
         * This works around @link https://github.com/facebook/hhvm/issues/6954, otherwise we would just type-hint in
         * the method signature above.
         */
        $dataProviders = array_map(function (DataProviderInterface $dataProvider) {
            return $dataProvider;
        }, $dataProviders);

        $values = array_reduce(
            $dataProviders,
            function (array $carry, DataProviderInterface $dataProvider) {
                $values = $dataProvider->values();

                if ($values instanceof \Traversable) {
                    $values = iterator_to_array($values);
                }

                return array_merge(
                    $carry,
                    $values
                );
            },
            []
        );

        return $this->provideData($values);
    }
}
