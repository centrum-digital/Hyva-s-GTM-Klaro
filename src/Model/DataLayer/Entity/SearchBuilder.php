<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class SearchBuilder
{
    public function __construct(private RequestInterface $request) {}

    /**
     * @param Collection $productCollection
     */
    public function build(Collection $productCollection): array
    {
        $term = trim((string)($this->request->getParam('q') ?? ''));
        $listName = $term !== '' ? sprintf('Search: %s', $term) : 'Search results';
        $listId   = $term !== '' ? 'search_' . substr(md5($term), 0, 8) : 'search';

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
            'search_term'    => $term,
            'item_list_id'   => $listId,
            'item_list_name' => $listName,
            'items'          => $items,
        ];
    }

}
