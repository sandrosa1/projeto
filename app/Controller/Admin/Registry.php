<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\AppSystem\Customer as EntityCustomer;
use \SandroAmancio\PaginationManager\Pagination;



class Registry extends Page{

      /**
     * Método reponsavel por obter a renderização da lista de clientes
     *
     * @param Request $request
     * @param Pagiation $objPagination OBS: Tudo que está nesse parametro pode ser acessado fora do metódo pois ele está sendo referenciado &
     * @return String
     */
    private static function getRegistryItems($request, &$objPagination){

        //lista
        $lists = '';

        //Quantidade de registro
        $quantidadeTotal = EntityCustomer::getCustomers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        
        //Pagina atual
        $queryParams        = $request->getQueryParams();
        $paginaAtual        = $queryParams['page'] ?? '1';
        $registrosPorPagina = 5 ;

        //Instancia de paginação
        $objPagination = new Pagination($quantidadeTotal,$paginaAtual,$registrosPorPagina);

        //Resultados da página
        $results = EntityCustomer::getCustomers(null,'id DESC',$objPagination->getLimit());

        while($objRegistry = $results->fetchObject(EntityCustomer::class)){

            $lists .= View::render('admin/modules/registry/list',[
                'id'           => $objRegistry->id,
                'user'         => $objRegistry->user,
                'phone'        => $objRegistry->phone,
                'email'        => $objRegistry->email,
                'data'         => $objRegistry->data,
                'businessName' => $objRegistry->businessName,
            ]);
        }

        //Retorno a lista de clientes
        return $lists;
    }

    /**
     * Renderiza a view de castrastro de clientes
     *
     * @param Request $request
     * @return String
     */
   public static function getRegistry($request){
       //Conteúdo da home
       $content = View::render('admin/modules/registry/index',[
           'lists'      => self::getRegistryItems($request, $objPagination),
           'pagination' => parent::getPagination($request, $objPagination),
           'status'     => self::getStatus($request)
       ]);

       return parent::getPanel('Cadastro - Admin', $content,'registry');

   }

   /**
    * Renderiza o formulário de cadastro de um novo cliente
    *
    * @param Request $request
    * @return String
    */
   public static function getNewRegistry($request){

       //Conteúdo da formularioa
       $content = View::render('admin/modules/registry/form',[
        'title'        => 'Cadastrar novo cliente',
        'user'         => '', 
        'businessName' => '', 
        'phone'        => '',
        'email'        => '',
        'status'       => ''
    ]);

    return parent::getPanel('Cadastro - Admin', $content,'registry');

   }

    /**
    *Cadastra um novo cliente
    *
    * @param Request $request
    * @return String
    */
    public static function setNewRegistry($request){

        //Post vars
        $postVars = $request->getPostVars();

        //Nova instancia de cliente
        $objCustomer = new EntityCustomer;

        $objCustomer->user = $postVars['user'] ?? '';
        $objCustomer->phone = $postVars['phone'] ?? '';
        $objCustomer->email = $postVars['email'] ?? '';
        $objCustomer->businessName = $postVars['businessName'] ?? '';
        $objCustomer->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        //Inclui cliente no Banco
        $objCustomer->cadastrarCustomer();

        //Redirecio o usúario
        $request->getRouter()->redirect('/admin/registry/'.$objCustomer->id.'/edit?status=created');

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
                return Alert::getSuccess('Cliente cadastrado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Cliente atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Cliente excluido com sucesso!');
                break;
            default:
                # code...
                break;
        }
    }

    /**
    * Renderiza o formulario de cadastro de um novo cliente
    *
    * @param Request
    * @param Integer $id
    * @return String
    */
   public static function getEditRegistry($request, $id){
        $objCustomer = EntityCustomer::getCustomerById($id);
        //Valida a instancia
        if(!$objCustomer instanceof EntityCustomer){
            $request->getRouter()->redirect('/admin/registry');
        }

        //Conteúdo da formularioa
        $content = View::render('admin/modules/registry/form',[
            'title'        => 'Editar cliente',
            'user'         => $objCustomer->user, 
            'businessName' => $objCustomer->businessName, 
            'phone'        => $objCustomer->phone,
            'email'        => $objCustomer->email,
            'status'       => self::getStatus($request)
        ]);

        return parent::getPanel('Editar cadastro - Admin', $content,'registry');

    }

    /**
    * Grava a atualização de um registro de cliente
    *
    * @param Request $request
    * @param Integer $id
    * @return String
    */
    public static function setEditRegistry($request, $id){
        //Obtem os cliente do banco de dados
        $objCustomer = EntityCustomer::getCustomerById($id);
        //Valida a instancia
        if(!$objCustomer instanceof EntityCustomer){
            $request->getRouter()->redirect('/admin/registry');
        }
        //Post vars
        $postVars = $request->getPostVars();

        $objCustomer->user = $postVars['user'] ?? $objCustomer->user;
        $objCustomer->phone = $postVars['phone'] ?? $objCustomer->phone;
        $objCustomer->email = $postVars['email'] ?? $objCustomer->email;
        $objCustomer->businessName = $postVars['businessName'] ??  $objCustomer->businessName;
        $objCustomer->password = password_hash($postVars['password'], PASSWORD_DEFAULT) ??  $objCustomer->password;
        $objCustomer->atualizarCustomer();

        //Redireciona o usúario
        $request->getRouter()->redirect('/admin/registry/'.$objCustomer->id.'/edit?status=updated');

    }


    /**
    * Renderiza o formulario de exclusão de um novo cliente
    *
    * @param Request
    * @param Integer $id
    * @return String
    */
   public static function getDeleteRegistry($request, $id){
    $objCustomer = EntityCustomer::getCustomerById($id);
    //Valida a instancia
    if(!$objCustomer instanceof EntityCustomer){
        $request->getRouter()->redirect('/admin/registry');
    }

    //Conteúdo da formularioa
    $content = View::render('admin/modules/registry/delete',[
        'title'        => 'Editar cliente',
        'user'         => $objCustomer->user, 
        'businessName' => $objCustomer->businessName, 
        'phone'        => $objCustomer->phone,
        'email'        => $objCustomer->email,
        'status'       => self::getStatus($request)
    ]);

    return parent::getPanel('Excluir cliente - Admin', $content,'registry');

    }

    /**
    * Exclui um registro de cliente
    *
    * @param Request $request
    * @param Integer $id
    * @return String
    */
    public static function setDeleteRegistry($request, $id){
        //Obtem os cliente do banco de dados
        $objCustomer = EntityCustomer::getCustomerById($id);
        //Valida a instancia
        if(!$objCustomer instanceof EntityCustomer){
            $request->getRouter()->redirect('/admin/registry');
        }
    
        //Exclui um cliente
        $objCustomer->excluirCustomer();

        //Redireciona o usúario
        $request->getRouter()->redirect('/admin/registry?status=deleted');

    }

}