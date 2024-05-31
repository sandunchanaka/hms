<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetCategoryRequest;
use App\Http\Requests\UpdatePetCategoryRequest;
//use App\Models\Operation;
use App\Models\PetCategory;
use App\Repositories\PetCategoryRepository;
use Illuminate\Http\Request;

class PetCategoryController extends AppBaseController
{
    private PetCategoryRepository $categoryRepository;

    public function __construct(PetCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return view('pet_categories.index');
    }

    public function store(StorePetCategoryRequest $request)
    {
        $input = $request->all();
        echo "test"; die;
        dd($input);
        $this->categoryRepository->create($input);

        return $this->sendSuccess(__('messages.pet_category.pet_category') . ' ' . __('messages.common.saved_successfully'));
    }

    public function edit(PetCategory $petCategory)
    {
        return $this->sendResponse($petCategory, 'Operation Category retrieved successfully.');
    }

    public function update(UpdatePetCategoryRequest $request, PetCategory $petCategory)
    {
        $input = $request->all();
        $this->categoryRepository->update($input, $petCategory->id);

        return $this->sendSuccess(__('messages.pet_category.pet_category') . ' ' . __('messages.common.updated_successfully'));
    }

    public function destroy(PetCategory $petCategory)
    {
        // $operationModels = [
        //     Pet::class,
        // ];

        // $result = canDelete($petModels, 'operation_category_id', $petCategory->id);

        // if ($result) {
        //     return $this->sendError(__('messages.pet_category.pet_category') . ' ' . __('messages.common.cant_be_deleted'));
        // }

        $petCategory->delete();

        return $this->sendSuccess(__('messages.pet_category.pet_category') . ' ' . __('messages.common.deleted_successfully'));
    }

    // public function getOperationName(Request $request)
    // {
    //     return Operation::where('operation_category_id', $request->id)->get()->pluck('id', 'name');
    // }
}