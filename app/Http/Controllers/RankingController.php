<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\PersonalRecord;
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

        $records = PersonalRecord::selectRaw('user_id, sum(value) as value')
                                    ->where('movement_id', $movement->id)
                                    ->groupBy('user_id')
                                    ->orderBy('value', 'desc')
                                    ->with('user')
                                    ->get();
                                    
        if(count($records) == 0){
            return response()->json(['msg' => 'Sem registros para esse movimento'], 404);
        }

        $recordsData = array();
        foreach($records as $k => $record){

            $position = $k+1;
            if(isset($recordsData[$k-1]) && $record->value == $recordsData[$k-1]['value']){
                $position = $k;
            }

            $recordsData[] = [
                'position' => $position,
                'name' => $record->user->name,
                'value' => $record->value,
            ];
        }

        return response()->json($recordsData);
    }
}
