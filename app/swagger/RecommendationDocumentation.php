<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class RecommendationDocumentation {

    #[OA\Post(
        path: "/api/recommendations/analyze/{plate_id}",
        summary: "Analyze a plate for the authenticated user",
        tags: ["Recommendations"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "plate_id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 202, description: "Recommendation processing"),
            new OA\Response(response: 404, description: "Plate not found")
        ]
    )]
    public function analyze(){}

    #[OA\Get(
        path: "/api/recommendations",
        summary: "List all recommendations of the authenticated user",
        tags: ["Recommendations"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "List of recommendations")
        ]
    )]
    public function index(){}

    #[OA\Get(
        path: "/api/recommendations/{plate_id}",
        summary: "Get a specific recommendation by plate",
        tags: ["Recommendations"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "plate_id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Recommendation details"),
            new OA\Response(response: 202, description: "Recommendation still processing"),
            new OA\Response(response: 404, description: "Recommendation not found")
        ]
    )]
    public function show(){}
}