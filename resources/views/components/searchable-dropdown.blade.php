<x-searchable-dropdown
    :items="$allclients"
    :item-id="$client_id"
    label="Client Name"
    input-id="NewClient"
    id-field="client_id"
    search-field="search"
    display-field="name"
    :show-create-button="true"
/>
 <!-- Car Dropdown -->
 <x-searchable-dropdown
 :items="$allcars"
 :item-id="$car_id"
 label="Car Model"
 input-id="NewCar"
 id-field="car_id"
 search-field="search"
 display-field="model"
 :show-create-button="true"
/>

<!-- Matricule Dropdown -->
<x-searchable-dropdown
 :items="$allmat"
 :item-id="$mat_id"
 label="Matricule"
 input-id="NewMat"
 id-field="mat_id"
 search-field="mat"
 display-field="mat"
 :show-create-button="false"
/> 
