@php
    use Behin\SimpleWorkflow\Models\Core\UserProfile;
    $customerId = $case->getVariable('user_profile_id');
    $customer = UserProfile::find($customerId);
    dd($customer);
@endphp