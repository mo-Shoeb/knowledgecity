<?php

namespace App\Controllers;

require __DIR__ . '/../autoload.php';

use App\Model\Category;
use App\Utils\Response;
use App\Utils\UUID;
use App\Utils\ValidateTrait;

class CategoryController
{

    use ValidateTrait;
    public $model;
    public function __construct()
    {
        $this->model = new Category(); // init model
    }

    /**
     * List Method
     */
    public function index()
    {
        $this->initJoinQuery();
        $data = $this->model->where('status', '=', 'active')->get();
        Response::success($data);
    }

    /**
     * Find Method
     */
    public function find($request)
    {
        $this->initJoinQuery();
        $data = $this->model->limit(1)->where('status', '=', 'active')->where('id', '=', $request["id"])->get();
        Response::success($data[0] ?? []);
    }

    /**
     * Get course count for each category
     */
    private function initJoinQuery()
    {
        return $this->model->joinCount(
            "courses",
            "`courses`.`category_id` = `categories`.`id`",
            "COUNT(courses.course_id) AS count_of_courses",
            "GROUP BY categories.id"
        );
    }

    /**
     * Creates new category
     */
    public function create()
    {
        $validation = $this->validate([
            "name" => "required|string",
            "parent_id" => "validateExists-Category-id",
        ]);

        if (@$validation->parent_id && !$this->validateLevels($validation->parent_id)) {
            Response::error(
                [
                    "success" => false,
                    "message" => "Category max level is 4 levels ."
                ]
            );
        }

        $this->model->save([
            "id" => UUID::generate(),
            "name" => $validation->name,
            "parent_id" => $validation->parent_id ?? NULL
        ]);

        Response::success([
            "success" => true,
            "message" => "Category Created"
        ]);
    }

    /**
     * PARTIAL update (Partial is OPTIONAL)
     */
    public function update()
    {
        $validation = $this->validate([
            "id" => "required|validateExists-Category-id",
            "name" => "required|string",
            "parent_id" => "validateExists-Category-id",
        ]);

        if (@$validation->parent_id && ($validation->id == $validation->parent_id)) {
            Response::error(
                [
                    "success" => false,
                    "message" => "Category can't be parent of it self"
                ]
            );
        }

        if (@$validation->parent_id && !$this->validateLevels($validation->parent_id)) {
            Response::error(
                [
                    "success" => false,
                    "message" => "Category max level is 4 levels ."
                ]
            );
        }

        $updateId = $validation->id;
        unset($validation->id);

        $this->model->update($validation, ["id" => $updateId]);

        Response::success([
            "success" => true,
            "message" => "Category Updated"
        ]);
    }

    /**
     * SOFT delete
     */
    public function delete()
    {
        $validation = $this->validate([
            "id" => "required|validateExists-Category-id",
        ]);

        $this->model->update(["status" => "deleted"], ["id" => $validation->id]);

        Response::success([
            "success" => true,
            "message" => "Category Deleted"
        ]);
    }

    /**
     * Validate Max Category 4 Levels
     */
    public function validateLevels($categoryId): bool
    {
        if(is_null($categoryId)) return true;

        $MAX_LEVEL = 4;

        $level = 1;
        $category = $this->model->where("status", "=", "active")->where("id", "=", $categoryId)->get();

        while (!is_null($category[0]['parent_id'])) {
            $level++;
            $category = $this->model->where("status", "=", "active")->where("id", "=", $category[0]['parent_id'])->get();
        }

        return $level < $MAX_LEVEL;
    }
}
