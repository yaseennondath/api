<?php

namespace PickBazar\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PickBazar\Database\Models\Type;
use PickBazar\Database\Repositories\AttributeValueRepository;
use PickBazar\Http\Requests\AttributeValueRequest;
use Prettus\Validator\Exceptions\ValidatorException;

class AttributeValueController extends CoreController
{
    public $repository;

    public function __construct(AttributeValueRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Collection|Type[]
     */
    public function index(Request $request)
    {
        return $this->repository->with('attribute')->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeValueRequest $request
     * @return mixed
     * @throws ValidatorException
     */
    public function store(AttributeValueRequest $request)
    {
        $validatedData = $request->all();
        return $this->repository->create($validatedData);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            return $this->repository->with('attribute')->findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Attribute Value not found!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeValueRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AttributeValueRequest $request, $id)
    {
        try {
            $validatedData = $request->all();
            return $this->repository->findOrFail($id)->update($validatedData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Attribute Value not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            return $this->repository->findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Attribute Value not found!'], 404);
        }
    }
}
