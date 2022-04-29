<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\PersonalRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RankingController extends Controller
{

    public function index($movement = null){
        if($movement == null){
            return response()->json(['msg' => 'O movimento é obrigatório'], 402);
        }

        $movement = Movement::find($movement);
        if($movement == null){
            return response()->json(['msg' => 'Movimento não encontrado'], 404);
        }
        
        $users = User::whereHas('records', function (Builder $query) use($movement) {
                            $query->where('movement_id', $movement->id);
                        })
                        ->with([
                            'records' => function ($query) use($movement) {
                                $query->where('movement_id', $movement->id);
                            }
                        ])
                        ->get();

        if(count($users) == 0){
            return response()->json(['msg' => 'Sem registros para esse movimento'], 404);
        }
        
        $recordsData = array();
        foreach($users as $k => $user){

            $recordsData[] = [
                'position'  => null,
                'name'      => $user->name,
                'value'     => $user->records[0]->value,
                'date'      => $user->records[0]->date,
            ];
        }

        usort($recordsData, function($a, $b) {return strcmp($b['value'], $a['value']);});

        foreach($recordsData as $k => $recordData){

            $position = $k+1;
            if(isset($recordsData[$k-1]) && $recordsData[$k-1]['value'] == $recordData['value']){
                $position = $recordsData[$k-1]['position'];
            }
            $recordsData[$k]['position'] = $position;
        }

        return response()->json($recordsData);
    }

    public function store(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
