<?php

namespace App\GraphQL\Type;

use App\Models\{ProformaProduit,Produit};
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ProformaProduitType extends GraphQLType
{

    protected $attributes =
    [
        'name' => 'ProformaProduit',
        'description' => ''
    ];

    
    public function fields():array
    {
        return
        [
            'id'                                                        => ['type' => Type::int(), 'description' => ''],
            'proforma_id'                                               => ['type' => Type::int(), 'description' => ''],
            'produit_id'                                                => ['type' => Type::int(), 'description' => ''],
            'prix_vente'                                                => ['type' => Type::int(), 'description' => ''],
            'qte'                                                       => ['type' => Type::int(), 'description' => ''],
            'proforma'                                                  => ['type' => GraphQL::type('Proforma'), 'description' => ''],
            'total'                                                     => ['type' => Type::int(), 'description' => ''],
            'remise'                                                    => ['type' => Type::int(), 'description' => ''],
            'pu_net'                                                    => ['type' => Type::float()],
            'montant_net'                                               => ['type' => Type::float()],
            'montant_remise'                                            => ['type' => Type::int(), 'description' => ''],
            'produit'                                                   => ['type' => GraphQL::type('Produit'), 'description' => ''],

            'created_at'                                                => ['type' => Type::string(), 'description' => ''],
            'updated_at'                                                => ['type' => Type::string(), 'description' => ''],
            'deleted_at'                                                => ['type' => Type::string(), 'description' => ''],
        ];
    }


    protected function resolveTotalField($root, $args)
    {
        if (!isset($root['total']))
        {
            $id = $root->id;
        }
        else
        {
            $id = $root['id'];
        }

        return $root['prix_vente'] * $root['qte'];
    }

    protected function resolveMontantRemiseField($root, $args)
    {
        $montant = $root['prix_vente'] * $root['qte'];
        $montant_remise = ($montant * $root['remise'])/100;
        return $montant_remise;
    }
    protected function resolveMontantNetField($root, $args)
    {
        $pu_net = $root['prix_vente'] - (($root['prix_vente']* $root['remise'])/100);
        $montant_net = $pu_net * $root['qte'];
        return $montant_net;
    }
    protected function resolvePuNetField($root, $args)
    {
        $pu_net = $root['prix_vente'] - (($root['prix_vente']* $root['remise'])/100);
        return $pu_net;
    }
    
}



