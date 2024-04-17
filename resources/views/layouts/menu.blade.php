<!-- {{-- <nav id="column_left">
    <ul class="nav nav-list">
        @if ( Auth::user()->hasPermission('view-agents') )
            <li class="nav-item {{ Request::is('agents*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agents.index') }}">
                    <i class="nav-icon icon-cursor"></i>
                    <span>Agents</span>
                </a>
            </li>
        @endif
        @if ( Auth::user()->hasPermission('view-cases') )
            <li class="nav-item {{ Request::is('cases*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cases.index') }}">
                    <i class="nav-icon icon-cursor"></i>
                    <span>Cases</span>
                </a>
            </li>
        @endif
    </ul>
</nav>

<li class="nav-item {{ Request::is('homes*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('homes.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Homes</span>
    </a>
</li> --}}
<li class="nav-item {{ Request::is('policyDetails*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('policyDetails.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Policy Details</span>
    </a>
</li>
<li class="nav-item {{ Request::is('evaluate*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url("evaluate") }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Evaluate</span>
    </a>
</li>
<li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Associates</span>
    </a>
</li>
<li class="nav-item {{ Request::is('cases*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('cases.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Cases</span>
    </a>
</li>
<li class="nav-item {{ Request::is('agents*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('agents.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Therapist</span>
    </a>
</li>
<li class="nav-item {{ Request::is('professionalPolicyDetails*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('professionalPolicyDetails.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Professional Policy Details</span>
    </a>
</li>
<li class="nav-item {{ Request::is('pinCodes*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pinCodes.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Pin Codes</span>
    </a>
</li>
<li class="nav-item {{ Request::is('products*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('products.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Products</span>
    </a>
</li>
<li class="nav-item {{ Request::is('documents*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('documents.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Documents</span>
    </a>
</li> -->


 <!-- <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
   
    <svg height="9" viewBox="0 0 13 9" width="13" class="ng-star-inserted">
        <path d="M1.66797 8L5.16797 4.5L1.66797 1"></path>
        <path d="M7.5 8L11 4.5L7.5 1"></path>
    </svg>
</a>
<li title="Home" class="main-link activeSelected">
    <a href="index.html">
        <i class="fa fa-home"></i>
        <span>Home</span>
    </a>
</li>
<li title="Agents" class="main-link">
    <a href="agents.html">
        <i class="fa fa-user"></i>
        <span>Agents</span>
    </a>
</li>
<li title="Products" class="main-link">
    <a href="products.html">
        <i class="fa fa-cubes"></i>
        <span>Products</span>
    </a>
</li>
<li title="Case Manager" class="main-link">
    <a href="CaseManager.html">
        <i class="fa fa-rocket"></i>
        <span>Case Manager</span>
    </a>
</li>
<li title="Service Desk" class="main-link">
    <a href="ServiceDesk.html">
        <i class="fa fa-gear"></i>
        <span>Service Desk</span>
    </a>
</li> -->
        
