<?php

namespace Project\Core;

use Bitrix\Main\Loader,
    Bitrix\Sale;

class Basket {

    static public function add($productId, $quantity) {
        if (Loader::includeModule('sale')) {
            $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
            if ($item = $basket->getExistsItem('catalog', $productId)) {
                $item->setField('QUANTITY', $item->getQuantity() + $quantity);
            } else {
                $item = $basket->createItem('catalog', $productId);
                $item->setFields(array(
                    'QUANTITY' => $quantity,
                    'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                    'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                ));
                /*
                  Если вы хотите добавить товар с произвольной ценой, нужно сделать так:
                  $item->setFields(array(
                  'QUANTITY' => $quantity,
                  'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                  'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
                  'PRICE' => $customPrice,
                  'CUSTOM_PRICE' => 'Y',
                  ));
                 */
            }
            $basket->save();
        }
        return false;
    }

}
