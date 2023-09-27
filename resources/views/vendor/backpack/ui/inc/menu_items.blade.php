{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Stakeholders" icon="la la-group">
    <x-backpack::menu-dropdown-item title="Collectors" icon="la la-user" :link="backpack_url('collector')" />
    <x-backpack::menu-dropdown-item title="Suppliers" icon="la la-user" :link="backpack_url('supplier')" />
    <x-backpack::menu-dropdown-item title="Consumers" icon="la la-user" :link="backpack_url('consumer')" />    
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Transactions" icon="la la-question" :link="backpack_url('transaction')" />
<x-backpack::menu-item title="History" icon="la la-question" :link="backpack_url('history')" />