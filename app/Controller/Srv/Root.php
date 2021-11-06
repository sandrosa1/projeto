<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Root\Root as EntityRoot;
use \SandroAmancio\PaginationManager\Pagination;



class Root extends Page{

      /**
     * Método reponsavel por obter a renderização da lista de colaboradores
     *
     * @param Request $request
     * @param Pagiation $objPagination OBS: Tudo que está nesse parametro pode ser acessado fora do metódo pois ele está sendo referenciado &
     * @return String
     */
    private static function getRootItems($request, &$objPagination){

        //lista
        $lists = '';

        //Quantidade de registro
        $quantidadeTotal = EntityRoot::getRoots(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        
        //Pagina atual
        $queryParams        = $request->getQueryParams();
        $paginaAtual        = $queryParams['page'] ?? '1';
        $registrosPorPagina = 5 ;

        //Instancia de paginação
        $objPagination = new Pagination($quantidadeTotal,$paginaAtual,$registrosPorPagina);

        //Resultados da página
        $results = EntityRoot::getRoots(null,'idRoot DESC',$objPagination->getLimit());

        while($objRoot = $results->fetchObject(EntityRoot::class)){
         
            $lists .= View::render('srv/modules/roots/list',[
                'idRoot'    => $objRoot->idRoot,
                'rootName'  => $objRoot->rootName,
                'userName'  => $objRoot->userName,
                'email'     => $objRoot->email,
                'type'      => $objRoot->type,
                'date'      => $objRoot->date,
            ]);
        }

        //Retorno a lista de colaboradores
        return $lists;
    }

    /**
     * Renderiza a view de castrastro de colaboradores
     *
     * @param Request $request
     * @return String
     */
   public static function getRoots($request){
       //Conteúdo da home
       $content = View::render('srv/modules/roots/index',[
           'lists'      => self::getRootItems($request, $objPagination),
           'pagination' => parent::getPagination($request, $objPagination),
           'status'     => self::getStatus($request)
       ]);

       return parent::getPanel('Colaboraores - SRV', $content,'roots');

   }

   /**
    * Renderiza o formulário de cadastro de um novo colaborador
    *
    * @param Request $request
    * @return String
    */
   public static function getNewRoot($request){

       //Conteúdo da formulario
       $content = View::render('srv/modules/roots/form',[
        'title'        => 'Cadastrar novo Colaborador',
        'rootName'     => '', 
        'userName'     => '', 
        'type'         => '', 
        'email'        => '',
        'status'       => self::getStatus($request) ?? ''
    ]);

    return parent::getPanel('Cadastro - SRV', $content,'roots');

   }

    /**
    * Cadastra um novo colaborador
    *
    * @param Request $request
    * @return String
    */
    public static function setNewRoot($request){

        //Post vars
        $postVars = $request->getPostVars();


        if($postVars['password1'] != $postVars['password2']){
            $request->getRouter()->redirect('/srv/roots/new?status=errorP');

        }elseif( strlen($postVars['password2']) < 8){
            $request->getRouter()->redirect('/srv/roots/new?status=errorM');

        }elseif( !preg_match('/^([0-9a-zA-Z]+)$/',$postVars['password2'])){

            $request->getRouter()->redirect('/srv/roots/new?status=errorC');

        }
        else{

            
            //Nova instancia de colaborador
            $objRoot = new EntityRoot;

            $objRoot->rootName = $postVars['rootName'] ?? '';
            $objRoot->userName = $postVars['userName'] ?? '';
            $objRoot->email = $postVars['email'] ?? '';
            $objRoot->password = password_hash($postVars['password1'], PASSWORD_DEFAULT);
            //Inclui colaborador no Banco
            $objRoot->cadastrarRoot();

            //Redirecio o usúario
            $request->getRouter()->redirect('/srv/roots/'.$objRoot->idRoot.'/edit?status=created');

        }

        

    }

    /**
     * Retorna a mensagem de status
     *
     * @param Request $request
     * @return String
     */
    private static function getStatus($request){
        //Query params
        $queryParams = $request->getQueryParams();
        
        //Status
        if(!isset($queryParams['status'])) return '';

        //Mensagens de status
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Novo administrador cadastrado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Novo administrador atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Administrador excluido com sucesso!');
                break;
            case 'errorP':
                return Alert::getError('As senhas estão diferentes.');
                break;
            case 'errorM':
                return Alert::getError('A senha precisa conter 8  dígitos.');
                break;
            case 'errorC':
                return Alert::getError('Dígitar somente letras e números se espaços.');
                break;
            case 'permissionError':
                return Alert::getError('Não tem permissão para executar essa ação.');
                break;
            default:
                return Alert::getError('Algo deu errado :(');
                break;
        }
    }

    /**
    * Renderiza o formulario de cadastro de um novo colaborador para edição
    *
    * @param Request
    * @param Integer $idRoot
        * @return String
        */
    public static function getEditRoot($request, $idRoot){

        if ($_SESSION['srv']['user']['iduser'] == $idRoot ){

                $objRoot = EntityRoot::getRootById($idRoot);
                //Valida a instancia
                if(!$objRoot instanceof EntityRoot){
                    $request->getRouter()->redirect('/srv/roots');
                }

                //Conteúdo da formulario
                $content = View::render('srv/modules/roots/form',[
                    'title'        => 'Editar colaborador',
                    'rootName'     => $objRoot->rootName, 
                    'userName'     => $objRoot->userName, 
                    'type'         => $objRoot->type, 
                    'email'        => $objRoot->email,
                    'status'       => self::getStatus($request)
                ]);

            return parent::getPanel('Editar cadastro - SRV', $content,'roots');

        } 
        
    $request->getRouter()->redirect('/srv/roots?status=permissionError');

    }

    /**
    * Grava a atualização de um registro de colaborador
    *
    * @param Request $request
    * @param Integer $idRoot
    * @return String
    */
    public static function setEditRoot($request, $idRoot){
        //Obtem os colaborador do banco de dados
        $objRoot = EntityRoot::getRootById($idRoot);
        //Valida a instancia
        if(!$objRoot instanceof EntityRoot){
            $request->getRouter()->redirect('/srv/roots');
        }
        //Post vars
        $postVars = $request->getPostVars();

        $objRoot->rootName = $postVars['rootName'] ?? $objRoot->rootName;
        $objRoot->userName = $postVars['userName'] ?? $objRoot->userName;
        $objRoot->email = $postVars['email'] ?? $objRoot->email;
        $objRoot->type = $postVars['type'] ??  $objRoot->type;
        $objRoot->password = password_hash($postVars['password'], PASSWORD_DEFAULT) ??  $objRoot->password;
        $objRoot->atualizarRoot();

        //Redireciona o usúario
        $request->getRouter()->redirect('/srv/roots/'.$objRoot->idRoot.'/edit?status=updated');

    }


    /**
    * Renderiza o formulario de exclusão de um novo colaborador
    *
    * @param Request
    * @param Integer $idRoot
    * @return String
    */
    public static function getDeleteRoot($request, $idRoot){


        if($_SESSION['srv']['root']['type'] == 3){

            $objRoot = EntityRoot::getRootById($idRoot);
            //Valida a instancia
            if(!$objRoot instanceof EntityRoot){
                $request->getRouter()->redirect('/srv/roots');
            }

            //Conteúdo da formularioa
            $content = View::render('srv/modules/roots/delete',[
                'title'        => 'Editar colaborador',
                'rootName'     => $objRoot->rootName, 
                'userName'     => $objRoot->userName, 
                'type'         => $objRoot->type, 
                'email'        => $objRoot->email,
                'status'       => self::getStatus($request)
            ]);

            return parent::getPanel('Excluir colaborador - SRV', $content,'roots');

        }

        $request->getRouter()->redirect('/srv/roots?status=permissionError');

    }

    /**
    * Exclui um registro de colaborador
    *
    * @param Request $request
    * @param Integer $idRoot
    * @return String
    */
    public static function setDeleteRoot($request, $idRoot){
        //Obtem os colaborador do banco de dados
        $objRoot = EntityRoot::getRootById($idRoot);
        //Valida a instancia
        if(!$objRoot instanceof EntityRoot){
            $request->getRouter()->redirect('/srv/roots');
        }

        //Exclui um colaborador
        $objRoot->excluirRoot();

        //Redireciona o usúario
        $request->getRouter()->redirect('/srv/roots?status=deleted');

    }

}