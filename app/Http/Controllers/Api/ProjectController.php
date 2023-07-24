<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\StoreNomeModelloRequest;
use App\Http\Requests\UpdateType;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Project::with("type", "technology")->paginate(3);

        $response = [
            "success" => true,
            "results" => $posts
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $projects = Project::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('technologies','projects','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNomeModelloRequest $request)
    {

        $data = $request->validated();

        $img_path = Storage::put("uploads", $data['image']);
        
        $data['image'] = $img_path;

        $newProject = new Project();
        $newProject->fill($data);
        $newProject->save();

        if ($request->has('technologies')) {
            $newProject->technologies()->attach($request->input('technologies'));
        }

        return to_route("admin.projects.show", $newProject->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $project = Project::findOrFail($id);
    $type = $project->type; 

    return view('admin.projects.show', compact('project', 'type'));
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'image'=> 'required',
            'content'=>'required',
            'type_id' => 'nullable|exists:types,id',
        ]);
    
        $project = Project::findOrFail($id);
        $project->name = $validatedData['name'];
  
        if ($request->has('type_id')) {
            $project->type_id = $validatedData['type_id'];
        }
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->input('technologies'));
        } else {
            $project->technologies()->detach();
        }
        $project->save();
    
     
    
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
    
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
