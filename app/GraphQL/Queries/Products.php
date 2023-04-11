<?php


namespace App\GraphQL\Queries;


use App\Models\Product;
use Illuminate\Support\Facades\Http;

class Products
{
    /**
     * @param $_
     * @param array $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        $page = $args['page'];
        $count = $args['count'];
        $products = [];
        $total = 0;

        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->successful()) {
            $data = $response->json();

            // Get the total number of products
            $total = count($data);

            // Calculate the offset based on the requested page and count
            $offset = ($page - 1) * $count;

            // Get the products for the requested page
            $productsData = array_slice($data, $offset, $count);

            // Transform the products data into an array of Product objects
            foreach ($productsData as $productData) {
                $product = new Product($productData['title'], $productData['description'], $productData['price']);
                $products[] = $product;
            }
        }

        // Calculate the pagination values
        $lastPage = ceil($total / $count);

        // Return the ProductList object
        return [
            'current_page' => $page,
            'last_page' => $lastPage,
            'per_page' => $count,
            'total' => $total,
            'data' => $products,
        ];
    }
}
