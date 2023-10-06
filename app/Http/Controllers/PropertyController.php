<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Property::all();
    }

    /**
     * Display a listing of the resource based on search value.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProperties(Request $request)
    {
        $data = Property::where('country', 'LIKE', "%{$request->keyword}%") 
            ->orWhere('description', 'LIKE', "%{$request->keyword}%") 
            ->get();

        return response()->json($data); 
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'county' => 'required|string|max:191',
            'image_full' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $requestData = $request->all();

        if($request->file('image_full')) {

            $image = $request->file('image_full');
            $imageName = time().'.'.$image->extension();
        
            $destinationPathThumbnail = public_path('/thumpnails');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail.'/'.$imageName);
        
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $imageName);

            $requestData['image_full'] = '/uploads/'.$imageName;
            $requestData['image_thumbnail'] = '/thumpnails/'.$imageName;
        }
        
        $property = Property::create($requestData);
        return response()->json([
            'message'=>'Property Created Successfully!!',
            'property'=>$property
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return $property;
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $requestData = $request->all();

        if($request->file('image_full')) {

            $image = $request->file('image_full');
            $imageName = time().'.'.$image->extension();
        
            $destinationPathThumbnail = public_path('/thumpnails');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail.'/'.$imageName);
        
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $imageName);

            $requestData['image_full'] = '/uploads/'.$imageName;
            $requestData['image_thumbnail'] = '/thumpnails/'.$imageName;
        }
        
        $property->fill($requestData)->save();
        return response()->json([
            'message'=>'Property Updated Successfully!!',
            'property'=>$property
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            'message'=>'Property Deleted Successfully!!'
        ]);
    }
}
