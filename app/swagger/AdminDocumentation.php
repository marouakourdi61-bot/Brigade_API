<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class AdminDocumentation {

    #[OA\Get(
        path: "/api/admin/stats",
        summary: "Get admin statistics",
        tags: ["Admin"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "Statistics for plates, categories, ingredients, recommendations"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function stats(){}
}