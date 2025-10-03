<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Hyva\Theme\ViewModel\CurrentCategory as HyvaCurrentCategory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class ListBuilder
{
    public function __construct(
        private HyvaCurrentCategory $currentCategory
    ) {}

    /**
     * @param Collection $productCollection
     */
    public function build(Collection $productCollection): array
    {
        $category = $this->currentCategory->get();
        $listName = $category ? (string) $category->getName() : null;
        $listId   = $category ? 'cat_' . $category->getId() : 'list_unknown';


        $items = [];
        $position = 1;

        foreach ($productCollection->load() as $product) {
            $items[] = [
                'item_id'   => (string)$product->getSku(),
                'item_name' => (string)$product->getName(),
                'price'     => (float)$product->getFinalPrice(),
                'index'     => $position,
            ];
            $position++;
        }

        return [
            'item_list_id'   => $listId,
            'item_list_name' => $listName,
            'items'          => $items,
        ];
    }
}
