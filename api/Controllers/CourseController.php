<?php

namespace App\Controllers;

require __DIR__ . '/../autoload.php';

use App\Model\Course;
use App\Model\Category;
use App\Utils\Response;
use App\Utils\ValidateTrait;

class CourseController
{

    use ValidateTrait;

    public $model;
    public $categoryModel;
    public function __construct()
    {
        $this->model = new Course(); // init model
        $this->categoryModel = new Category(); // init catetgoru model
    }

    /**
     * List Method
     */
    public function index()
    {
        $data = $this->model->where('status', '=', 'active')->get();
        foreach ($data as $val) {
            $formattedData[] = [
                "id" => $val['course_id'],
                "name" => $val['title'],
                "description" => $val['description'],
                "preview" => $val['image_preview'],
                "category_id" => $val['category_id'],
                "main_category_name" => $this->mainCategoryName($val['category_id']),
                "created_at" => $val['created_at'],
                "updated_at" => $val['updated_at']
            ];
        }
        Response::success($formattedData);
    }

    /**
     * Find Method
     */
    public function find($request)
    {
        $data = $this->model->limit(1)->where('status', '=', 'active')->where('course_id', '=', $request["id"])->get();
        if (!$data || count($data) == 0) {
            Response::success([]);
        }
        $formattedData[] = [
            "id" => $data[0]['course_id'],
            "name" => $data[0]['title'],
            "description" => $data[0]['description'],
            "preview" => $data[0]['image_preview'],
            "category_id" => $data[0]['category_id'],
            "main_category_name" => $this->mainCategoryName($data[0]['category_id']),
            "created_at" => $data[0]['created_at'],
            "updated_at" => $data[0]['updated_at']
        ];

        Response::success($formattedData[0] ?? []);
    }

    /**
     * Creates new course
     */
    public function create()
    {
        $validation = $this->validate([
            "course_id" => "required|string",
            "title" => "required|string",
            "description" => "string",
            "image_preview" => "required|url",
            "category_id" => "required|string|validateExists-Category-id",
        ]);

        $this->model->save([
            "course_id" => $validation->course_id,
            "title" => $validation->title,
            "description" => $validation->description ?? NULL,
            "image_preview" => $validation->image_preview,
            "category_id" => $validation->category_id,
        ]);

        Response::success([
            "success" => true,
            "message" => "Course Created"
        ]);
    }

    /**
     * PARTIAL update (Partial is OPTIONAL)
     */
    public function update()
    {
        $validation = $this->validate([
            "course_id" => "required|string|validateExists-Course-course_id",
            "title" => "string",
            "description" => "string",
            "image_preview" => "url",
            "category_id" => "string|validateExists-Category-id",
        ], (object)['min' => 2]);

        $updateId = $validation->course_id;
        unset($validation->course_id);

        $this->model->update($validation, ["course_id" => $updateId]);

        Response::success([
            "success" => true,
            "message" => "Course Updated"
        ]);
    }

    /**
     * SOFT delete
     */
    public function delete()
    {
        $validation = $this->validate([
            "course_id" => "required|validateExists-Course-course_id",
        ]);

        $this->model->update(["status" => "deleted"], ["course_id" => $validation->course_id]);

        Response::success([
            "success" => true,
            "message" => "Course Deleted"
        ]);
    }

    /**
     * GET Main Category Name
     */
    public function mainCategoryName($categoryId)
    {
        $category = $this->categoryModel->where("id", "=", $categoryId)->get();
        
        if(count($category) == 0) return "";
        
        while(!is_null($category[0]['parent_id'])){
            $category = $this->categoryModel->where("id", "=", $category[0]['parent_id'])->get();
        }

        return @$category[0]['name'] ?? "";
    }
}
