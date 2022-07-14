<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Note;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {

        if (!\Gate::allows('isAdmin')) {
            abort(403, "Sorry you not admin");
        } else {
            return ['message' => 'You must be an admin!'];
        }
        
        // print "<pre>user:";print_r(auth());exit;
        // $noteFields = [
        //     'note' => 'A new note',
        //     'product_id' => 1,
        //     'user_id' => Auth::id()
        // ];
        // //return Note::save($note);
        // Note::create($noteFields);
    }

}