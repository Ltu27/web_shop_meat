<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const SEARCH_FIELDS = [
        // 'name' => 'campaigns.name',
        // 'keywords' => 'campaigns.keywords',
        // // 'types' => 'types:master.value',
        // 'client' => 'clients:clients.name',
        // 'sale_staff' => 'saleStaff:users.name',
        // 'person_in_charge' => 'personInCharge:users.name',
    ];

    public const FROM_FIELDS = [
        // 'campaign_start_date' => 'campaigns.campaign_start_date',
        // 'campaign_end_date' => 'campaigns.campaign_end_date',
        // 'secretariat_end_date' => 'campaigns.secretariat_end_date',
    ];

    public const TO_FIELDS = [
        // 'campaign_start_date' => 'campaigns.campaign_start_date',
        // 'campaign_end_date' => 'campaigns.campaign_end_date',
        // 'secretariat_end_date' => 'campaigns.secretariat_end_date',
    ];

    public const IN_SET_FIELDS = [
        // 'keywords' => 'campaigns.keywords',
    ];

    public const HAS_FIELDS = [
        //?has[filed]=value&has[filed2]=value2
        // 'type' => 'types:master.id',
        // 'client' => 'clients:campaign_client.client_id',
        // 'client_pic' => 'clients:campaign_client.client_pic_id',
        // 'contact_information' => 'contactInformations:campaign_contact_informations.type_id',
        // 'part_time_employee' => 'partTimeEmployees:campaign_part_time_employee.user_id',
        // 'partner' => 'orderScopePartner:campaign_order_scope_partner.partner_id',
        // 'sale_staff_team' => 'saleStaff:users.team_id',
        // 'person_in_charge_team' => 'personInCharge:users.team_id',
        // 'person_in_charge_role' => 'personInCharge:users.role_id',
    ];
    public const FILTER_FIELDS = [
        'status' => 'orders.status',
        // 'id' => 'campaigns.id',
        // 'campaign_type' => 'campaigns.campaign_type',
        // 'sale_staff' => 'campaigns.sale_staff_id',
        // 'person_in_charge' => 'campaigns.person_in_charge_id',
        // 'progress_status' => 'campaigns.progress_status',
        // 'created_by' => 'campaigns.created_by',
        // 'is_approved' => 'campaigns.is_approved',
        // 'project_management' => 'campaigns.project_management_id',
        // 'customer_team_pic' => 'campaigns.customer_team_pic_id',
    ];

    public const SORT_FIELDS = [
        // 'id' => 'campaigns.id',
    ];

    protected $appends = ['totalPrice'];

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'token', 'customer_id', 'status',
    ];

    public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function details() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function getTotalPriceAttribute() {
        $t = 0;
        foreach ($this->details as $item) {
            $t += $item->price * $item->quantity;
        }
        return $t;
    }
}
