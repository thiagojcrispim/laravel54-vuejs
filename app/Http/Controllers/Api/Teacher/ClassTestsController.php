<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassTestRequest;
use App\Models\ClassTeaching;
use App\Models\ClassTest;

class ClassTestsController extends Controller
{
    public function index(ClassTeaching $classTeaching)
    {
        $results = ClassTest
            ::where('class_teaching_id', $classTeaching->id)
            ->byTeacher(\Auth::user()->userable->id)
            ->get();
        return $results;
    }

    public function store(ClassTestRequest $request,ClassTeaching $classTeaching)
    {
        return ClassTest::createFully($request->all()+['class_teaching_id' => $classTeaching->id]);
    }

    public function update(ClassTestRequest $request,ClassTeaching $classTeaching,ClassTest $classTest)
    {
        return $classTest->updateFully($request->all());
    }

    public function show(ClassTeaching $classTeaching, $id)
    {
        $result = ClassTest
            ::byTeacher(\Auth::user()->userable->id)
            ->findOrFail($id);
        $array = $result->toArray();
        $array['questions'] = $result->questions;
        return $result;
    }

    public function destroy(ClassTeaching $classTeaching,$classTestId)
    {
        $classTest = ClassTest
            ::byTeacher(\Auth::user()->userable->id)
            ->findOrFail($classTestId);
        $classTest->deleteFully();
        return response()->json([],204);
    }
}
