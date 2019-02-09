<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileSet;
use DB;

class FilesController extends Controller
{

  public function runSearch(Request $request) {
    $main = $request->main;
    $type = $request->type;
    $school_year = $request->school_year;
    $uploader = $request->uploader;
    $department = $request->department;

    if ($main !=null) {
      $query_priority = "SELECT * FROM file_sets WHERE name LIKE '%{$main}%' ";
    } else {
      $query_priority = "SELECT * FROM file_sets WHERE FALSE ";
    }
    $query_additional = $query_priority;

    if ($type != null) {
      $query_priority .= "AND type LIKE '%{$type}%' ";
      $query_additional .= "OR type LIKE '%{$type}%' ";
    }
    if ($school_year != null) {
      $query_priority .= "AND school_year LIKE '%{$school_year}%' ";
      $query_additional .= "OR school_year LIKE '%{$school_year}%' ";
    }
    if ($uploader != null) {
      $query_priority .= "AND uploader LIKE '%{$uploader}%' ";
      $query_additional .= "OR uploader LIKE '%{$uploader}%' ";
    }
    if ($department != null) {
      $query_priority .= "AND department LIKE '%{$department}%' ";
      $query_additional .= "OR department LIKE '%{$department}%' ";
    }

    $results_priority = DB::select($query_priority);
    $results_additional = DB::select($query_additional);

    $queries = array(
      'priority' => $query_priority,
      'additional' => $query_additional,
    );

    $results = array(
      'priority' => $results_priority,
      'additional' => $results_additional
    );

    return compact('results');

  }

  public function wildSearch(Request $request) {

    $search = $request->search_string;

    return view('files.search', compact('search'));

  }

  public function setUpload() {

    $folders_db = new \App\Folder;
    $folders = $folders_db->all();

    return view('files.upload', compact('folders'));

  }

  public function uploadFiles(Request $request) {

    $fileset = new \App\FileSet;

    try {
      // check if fileset is already existing
      if ($fileset->where('name', $request->file_set)->get()->count() > 0) {
        // if fileset exists: get the id then add the files
        $fileset_id = $fileset->where('name', $request->file_set)->get()[0]->id;

        // save each file from the set
        for ($i = 0; $i < count($request['files']); $i++) {
          $index = $request['files'][$i];
          $filedata = new \App\File;
          $filedata->index = $index['index'];
          $filedata->value = $index['value'];
          $filedata->height = $index['height'];
          $filedata->width = $index['width'];
          $filedata->file_set_id = $fileset_id;
          $filedata->save();
        }

        $response = array('id'=>$fileset_id);
        return response($response);

      } else {
        // else: create a new one
        $fileSet = new \App\FileSet;

        $fileSet->name =          $request->file_set;
        $fileSet->uploader =      $request->uploader;
        $fileSet->type =          $request->file_type;
        $fileSet->school_year =   $request->school_year;
        $fileSet->associated_id = $request->associated_id;
        $fileSet->department =    $request->department;
        $fileSet->folder_id =     $request->folder;
        $fileSet->save();

        // save each file from the set
        for ($i = 0; $i < count($request['files']); $i++) {
          $index = $request['files'][$i];
          $filedata = new \App\File;
          $filedata->index = $index['index'];
          $filedata->value = $index['value'];
          $filedata->height = $index['height'];
          $filedata->width = $index['width'];
          $filedata->file_set_id = $fileSet->id;
          $filedata->save();
        }

        $response = array('id'=>$fileSet->id, 'request'=> $request);
        return response($response);

      }

    } catch (\Exception $e) {
      return $e->getMessage();

    }

  }

  public function getSearchPage() {

    return view('files.search');

  }

  public function viewFileSet(FileSet $fileset) {

    return view('files.view', compact('fileset'));

  }

  public function viewFolders(Request $request) {

    return view('files.folders');

  }

}
