<!-- Dashboards -->
<li class="menu-item">
    <a href="/" class="menu-link">
        <i class="menu-icon tf-icons bx bx-objects-horizontal-right"></i>
        <div data-i18n="Dashboards">Dashboards</div>
    </a>
</li>
<ul class="menu-inner py-1">
    {{-- {{ dd($menuArray) }} --}}
    @foreach ($menuArray as $header => $menus)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="{{ $header }}">{{ $header }}</span>
        </li>

        @if (isset($menus['menus']) && is_array($menus['menus']))
            @foreach ($menus['menus'] as $menuName => $subMenus)
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        @if (isset($subMenus['icon']))
                            <i class="menu-icon {{ $subMenus['icon'] }}"></i>
                        @endif
                        <div>{{ $menuName }}</div>
                    </a>
                    <ul class="menu-sub">
                        @if (isset($subMenus) && is_array($subMenus))
                            @foreach ($subMenus as $subMenu)
                                @if (isset($subMenu['url']) && isset($subMenu['name']))
                                    <li class="menu-item">
                                        <a href="{{ $subMenu['url'] }}" class="menu-link">
                                            <div>{{ $subMenu['name'] }}</div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endforeach
        @endif
    @endforeach
    <!-- Misc -->
    <li class="menu-header small text-uppercase mt-3">
        <span class="menu-header-text" data-i18n="Misc">Misc</span>
    </li>
    <li class="menu-item">
        <a href="https://pixinvent.ticksy.com/" target="_blank" class="menu-link">
            <i class="menu-icon tf-icons bx bx-help-circle"></i>
            <div data-i18n="FAQ">FAQ</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="https://pixinvent.ticksy.com/" target="_blank" class="menu-link">
            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Support">Support</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="https://demos.pixinvent.com/frest-html-admin-template/documentation/" target="_blank"
            class="menu-link">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <div data-i18n="Documentation">Documentation</div>
        </a>
    </li>

</ul>
