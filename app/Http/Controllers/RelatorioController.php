<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\ReciboVO;
use App\Http\ViewObject\MovimentacaoVO;
use App\Http\ViewObject\AdministrarVO;
//use App\Http\Enum\UsuarioEnum;

use App\JSONUtils;
use App\Messages;
//use App\Contrato;
use App\Movimentacao;
use App\Recibo;
//use App\HistoricoAluguel;

class RelatorioController extends Controller
{

    public function index($id = null)
    {  
        try{
            if ($id == null) {
                
                $contrato = Movimentacao::orderBy('id', 'asc')->get();
                //$contrato = Contrato::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();

                $return = array();

                foreach ($contrato as $key => $value) {
                    $cVO = new AdministrarVO(Contrato::find($value->id));
                    $return[] = $cVO;
                }

                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
            } else {
                return $this->show($id);
            }
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function gerar(Request $request)
    {  
        try{
                $id_pessoa  = $request->input('id_pessoa');
                $mes        = $request->input('mes');
                $ano        = $request->input('ano');
                
                $recibo = Recibo::where('id_inquilino', '=', $id_pessoa)
                                    ->where('ano', '=', $ano)
                                    ->where('mes', '=', $mes)
                                    ->orderBy('id', 'asc')
                                    ->get();
                //$contrato = Contrato::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();
                
                $return = array();

                foreach ($recibo as $key => $value) {
                    $cVO = new ReciboVO(Recibo::find($value->id));
                    $return[] = $cVO;
                }
                

                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
            
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function gerarInquilino($id, Request $request)
    {  
        try{
                $mes        = $request->input('mes');
                $ano        = $request->input('ano');
                
                $recibo = Recibo::where('id_inquilino', '=', $id)
                                    ->where('ano', '=', $ano)
                                    ->where('mes', '=', $mes)
                                    ->orderBy('id', 'asc')
                                    ->get();
                
                //$contrato = Contrato::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();
                
                $return = array();
            
                foreach ($recibo as $key => $value) {
                    $cVO = new ReciboVO(Recibo::find($value->id));
                    $return[] = $cVO;
                }
                
                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
            
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function gerarProprietario($id, Request $request)
    {  
        try{
                $mes        = $request->input('mes');
                $ano        = $request->input('ano');
                
        /*        $recibo = Recibo::where('recibos.id_proprietario', '=', $id)
                                    ->rightJoin('imovels', 'recibos.id_imovel', '=', 'imovels.id')
                                    ->where('ano', '=', $ano)
                                    ->where('mes', '=', $mes)
                                    ->orderBy('recibos.id', 'asc')
                                    ->get();
        */        
                $recibo = \DB::select('SELECT imovels.*,
                                            p.nm_pessoa as nomeproprietario,
                                            p.nr_cpf as cpfproprietario,
                                            pes.nm_pessoa as nomeinquilino,
                                            pes.nr_cpf as cpfinquilino,
                                            recibos.id as recibo, 
                                            recibos.valor as valorrecibo,
                                            recibos.id_inquilino as inquilino 
                                        FROM imovels 
                                        INNER JOIN pessoas p ON imovels.id_proprietario = p.id
                                        LEFT JOIN recibos ON recibos.id_imovel = imovels.id 
                                                          AND recibos.mes = '.$mes.' 
                                                          AND recibos.ano = '.$ano.' 
                                        LEFT JOIN pessoas pes ON recibos.id_inquilino = pes.id
                                        WHERE imovels.id_proprietario = '.$id);
                //$contrato = Contrato::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();
            /*    $return = array();
            
                foreach ($recibo as $key => $value) {
                    $cVO = new ReciboVO(Recibo::find($value->id));
                    $return[] = $cVO;
                }
                dd($return);
            */                    
                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $recibo);
            
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function gerarImovel($id, Request $request)
    {  
        try{
                $ano        = $request->input('ano');
                
                $recibo = Movimentacao::where('id_imovel', '=', $id)
                                    ->where('ano', '=', $ano)
                                    ->orderBy('id', 'asc')
                                    ->get();
                
                //$contrato = Contrato::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();
                
                $return = array();
            
                foreach ($recibo as $key => $value) {
                    $cVO = new MovimentacaoVO(Movimentacao::find($value->id));
                    $return[] = $cVO;
                }

                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
            
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    

}
