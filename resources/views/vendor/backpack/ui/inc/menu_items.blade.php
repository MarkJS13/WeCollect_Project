{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Collectors" icon="la la-question" :link="backpack_url('collector')" />
<x-backpack::menu-item title="Suppliers" icon="la la-question" :link="backpack_url('supplier')" />
<x-backpack::menu-item title="Consumers" icon="la la-question" :link="backpack_url('consumer')" />
<x-backpack::menu-item title="Transactions" icon="la la-question" :link="backpack_url('transaction')" />