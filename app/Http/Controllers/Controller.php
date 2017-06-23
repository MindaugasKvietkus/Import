<?php

namespace App\Http\Controllers;

use App\Import;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function page(){

        //$cells = DB::table('imports')->get();

        $cells = DB::table('imports')->orderBy('id', 'asc')->get();

        $last_record = DB::table('imports')->orderBy('id', 'desc')->first();
        return view('welcome', array(
            'cells' => $cells,
            'last_record' => $last_record,
        ));
    }

    public function page_update(Request $request, $id){

        $cell_update = Import::find($id);

        $cell_update->cell_first = $request->cell_first;
        $cell_update->cell_second = $request->cell_second;
        $cell_update->cell_third = $request->cell_third;
        $cell_update->cell_fourth = $request->cell_fourth;
        $cell_update->save();

        return redirect('/');

    }

    public function delete($id, Request $request){

        $cell = Import::findOrFail( $id );

        if ( $request->ajax() ) {
            $cell->delete( $request->all() );

            return response(['msg' => 'Product deleted', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);

        /*DB::table('imports')->where('id', '=', $id)->delete();

        return redirect('/');
*/
    }

    public function import(Request $request){

        $file = $request->file('file');

        if ($file->getClientSize() === 0){
            return redirect('/')->with('empty', 'Failas tuščias!');
        }
        else{
            $path = $file->getPathname();
            $file_name = $file->getFilename();

            $file_open = fopen($path, "r");

            while ( ($data = fgetcsv($file_open, 200, ",")) !==FALSE) {

                $array_to_string = implode("|",$data);;

                $string = explode("|", $array_to_string);

                $import = new Import();
                $import->cell_first = $string[0];
                $import->cell_second = $string[1];
                $import->cell_third = $string[2];
                $import->cell_fourth = $string[3];
                $import->save();

            }
            fclose($file_open);
        }

        //$request->session()->flash('alert-success', 'User was successful added!');
        return redirect('/')->with('success', 'Failas sėkmingai įkeltas!');

    }
}
