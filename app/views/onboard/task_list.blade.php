<tbody>
  <tr>
    <td width="5%" align="center">&nbsp;</td>
    <td width="30%" align="center"><strong>Checklist</strong>
    <a href="#" class="add_to_list" data-toggle="modal" id="positionopen" data-target="#checklist-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
    </td>
    <td width="20%" align="center"><strong>Task Owner</strong></td>
    <td width="20%" align="center"><strong>Task Date</strong></td>
    <td width="20%" align="center"><strong>Status</strong></td>
    <td width="5%" align="center">Delete</td>
  </tr>

@if(isset($check_list) && count($check_list) > 0)
  @foreach($check_list as $key=>$check_row)
  <tr id="TemplateRow_{{ $check_row['checklist_id'] }}">
    <td align="center"><p class="custom_chk"><input type="checkbox" data-checklist_id="{{ $check_row['checklist_id'] }}" class="addto_task" id='addto_task{{ $check_row['checklist_id'] }}' checked><label for="addto_task{{ $check_row['checklist_id'] }}" style="width: 5px!important; margin: 1px 0 0 1px;">&nbsp;</label></p></td>
    
    <td align="center">{{ $check_row['name'] or "" }}</td>
 
    <td align="center" id="ownerdrop_{{ $check_row['checklist_id'] }}">
      <select class="form-control newdropdown status_dropdown" name="owner" id="owner">
        <option value="">None</option>
        @if(!empty($owner_list))
          @foreach($owner_list as $key=>$staff_row)
          <option value="{{ $staff_row['owner_id'] }}_{{ $staff_row['contact_type'] }}">{{ ucwords($staff_row['name']) }}</option>
          @endforeach
        @endif
      </select>
    </td>
    <td align="center">
      <div style="position: relative;" class="edit_cal">
        <a href=""><span id="frequency"></span> </a>
        <span class="glyphicon glyphicon-chevron-down open_adddrop" data-onboarding_id="1"></span> 
       <span></span>
        <div class="cont_add_to_date open_dropdown" id="idopen_dropdown_1" style="display: none;">
          <ul>
            <li>
              <a href="javascript:void(0)" id="addeditshow" class="open_calender_pop" data-client_id="">Add/Edit Start Date</a>
            </li>
            <li>
              <a href="javascript:void(0)" id="gocalender" class="" data-client_id="">Add to Calender</a>
            </li>
          </ul>
        </div>
      </div>
    </td>

    <td align="center" id="statusdrop_{{ $check_row['checklist_id'] }}">
      <select class="form-control newdropdown status_dropdown" name="status" id="status">
        <option value="N">Not Started</option>
        <option value="D">Done</option>
        <option value="W">WIP</option>
      </select>
    </td>

    <td align="center">
      <a href="javascript:void(0)" class="DeleteBoxRow" data-checklist_id="{{ $check_row['checklist_id'] }}"><img src="/img/cross.png"></a>
    </td>

  </tr>
  @endforeach
  @endif
  </tbody>