<div class="sidebar clearfix">

    <ul class="sidebar-panel nav">
        <li class="sidetitle">MAIN</li>
        @if (Request::is('dashboard/*'))
        <li><a href="/dashboard"><span class="icon color5"><i class="fa fa-home"></i></span>Dashboard<span class="label label-default">2</span></a></li>
        @endif
        <!-- <li><a href="mailbox.html"><span class="icon color6"><i class="fa fa-envelope-o"></i></span>Mailbox<span class="label label-default">19</span></a></li> -->

        @if (Request::is('facturation_gestion_financiere/*'))
        <li>
            <a href="#"><span class="icon color7"><i class="fa fa-money"></i></span>Dépenses<span class="caret"></span></a>
            <ul>
                <li><a href="{{route('expenses.index')}}">Liste des dépenses</a></li>
                <li><a href="{{route('categ_expenses.index')}}">Liste des catégories de dépenses</a></li>
                <li>
                    <a href="{{route('expenses_requests.index')}}">Liste des requêtes de dépense</a>
                </li>
            </ul>

        </li>
        @endif

        @if (Request::is('gestion_stock/*'))
        <li>
            <a href="#"><span class="icon color7"><i class="fa fa-money"></i></span>Gestion du stock<span class="caret"></span></a>
            <ul>
                <li><a href="{{route('drugs.index')}}">Liste des médicaments</a></li>
                <li><a href="{{route('materiels.index')}}">Liste des matériels</a></li>
                <li><a href="{{route('purchases.index')}}">Approvisionnement </a></li>
                <li><a href="{{route('sales.index')}}">Ventes / Sorties </a></li>
                <li><a href="{{route('stockmovements')}}">Fiche de stock </a></li>
            </ul>
        </li>
        @endif

        @if (Request::is('gestion_utilisateur/*'))
        <li>
            <a href="#"><span class="icon color7"><i class="fa fa-money"></i></span>Gestion des utilisateurs<span class="caret"></span></a>
            <ul>
                <li><a href="{{route('users.index')}}">Liste des utilisateurs</a></li>
                <li><a href="{{route('expenses.index')}}">Liste des rôles </a></li>
                <li>
                    <a href="{{route('expenses_requests.index')}}">Liste des permissions</a>
                </li>
            </ul>

        </li>
        @endif

        @if (Request::is('gestion_ticket/*'))
        <li>
            <a href="#"><span class="icon color7"><i class="fa fa-money"></i></span>Tickets<span class="caret"></span></a>
            <ul>
                <li><a href="{{route('tickets.index')}}"> Mes tickets</a></li>
            </ul>
        </li>
        @endif
        @if (Request::is('gestion_patients/*'))
        <li>
            <a href="#"><span class="icon color7"><i class="fa fa-money"></i></span>Patients<span class="caret"></span></a>
            <ul>
                <li><a href="{{route('patients.index')}}">Liste des patients</a></li>
                <li><a href="{{route('consultations.index')}}">Liste des consultations</a></li>
                <li><a href="{{route('appointments.index')}}">Calendrier des Rendez-vous</a></li>
            </ul>
        </li>
        @endif
</div>