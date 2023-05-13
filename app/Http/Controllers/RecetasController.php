<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RecetasController extends Controller
{
    public function getAllRecipes() {

        $filePath = base_path('world.json');
        $jsonString = file_get_contents($filePath);
        $recipes = json_decode($jsonString);

        $recetas = $this->parseRecipes($recipes);

        return new Response(json_encode($recetas), 200, ['content-type' => 'application/json']);

    }

    public function getOneRecipe($number) {

        $filePath = base_path('world.json');
        $jsonString = file_get_contents($filePath);
        $recipes = json_decode($jsonString);

        $receta = $this->searchRecipe($recipes, $number);

        return new Response(json_encode($receta), 200, ['content-type' => 'application/json']);
    }

    public function parseRecipes($jsonArray) {
        $recipes = array();
        foreach ($jsonArray as $item) {
            if (isset($item->{'@type'}) && $item->{'@type'} === "Recipe") {
                $recipe = array(
                    "id" => $item->{'@id'} ?? "",
                    "name" => $item->name,
                    "description" => $item->description,
                    "image" => $item->image[0] ?? "",
                );
                array_push($recipes, $recipe);
            }
        }
        return $recipes;
    }

    public function searchRecipe($jsonArray, $number) {
        foreach ($jsonArray as $item) {

            if ($item->id === $number) {
                return json_encode($item);
            }
        }
    }

}
