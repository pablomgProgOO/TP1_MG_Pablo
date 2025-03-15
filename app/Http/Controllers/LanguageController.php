<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Http\Resources\LanguageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index()
    {
        return LanguageResource::collection(Language::paginate(20));
    }

    public function show(Language $language)
    {
        return new LanguageResource($language);
    }

}

