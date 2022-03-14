<?php
return [
            [
                'icon' => null,
                'text' => 'Navigation',
                'link' => null
            ],
            [
                'icon' => 'th-large',
                'text' => 'Dashboard',
                'link' => route('home.index')
            ],
            [
                'icon' => null,
                'text' => 'Product',
                'link' => null
            ],
            [
                'icon' =>'shopping-bag',
                'text' => 'Products',
                'link' => route('product.index'),
                'route' => 'product.index'
            ],
            [
                'icon' => 'plus-circle',
                'text' => 'New Product',
                'link' => route('product.new'),
                'route' => 'product.new'
            ],
            // [
            //     'icon' => 'tags',
            //     'text' => 'Tag',
            //     'link' => route('tag.index'),
            //     'route' => 'tag.index'
            // ]
        ];