@php
    use App\Models\User;
    use Behin\SimpleWorkflow\Models\Entities\Users_profile;
    use Behin\SimpleWorkflow\Models\Entities\Requests;
    use Behin\SimpleWorkflow\Models\Entities\Panels;
    use Behin\SimpleWorkflow\Models\Entities\Invertors;
    use Behin\SimpleWorkflow\Models\Entities\Request_panels;
    use Behin\SimpleWorkflow\Models\Entities\Request_invertors;
    use Behin\SimpleWorkflow\Models\Entities\Powerhouse_place_info;
    $customerId = $case->getVariable('user_profile_id');
    $customer = Users_profile::find($customerId);
    $powerhousePlaceInfoId = $case->getVariable('powerhouse_place_info-id');
    $powerhousePlaceInfo = Powerhouse_place_info::find($powerhousePlaceInfoId);
    $contractorId = $case->getVariable('request-contractor_id');
    $contractor = User::find($contractorId);
    $technicianHeadId = $case->getVariable('request-technician_head_id');
    $technicianHead = User::find($technicianHeadId);
    $inspectorId = $case->getVariable('inspector');
    $inspector = User::find($inspectorId);
    $requestId = $case->getVariable('request-id');
    $request = Requests::find($requestId);
    $usedPanels = Request_panels::where('request_id', $requestId)->get();
    $usedInvertors = Request_invertors::where('request_id', $requestId)->get();
@endphp