<template>
    <div class="rounded-[6px] min-h-[350px] w-2/3 flex" id="map-container"></div>
</template>

<script setup>
import { computed, inject, watch, onMounted, reactive } from "@vue/runtime-core";


const emit = defineEmits(['address_selected'])
const props = defineProps({
    center: {
        type: Object,
        default: {
            lat: null,
            lng: null,
        }
    },
    defaultCenter: {
        type: Object,
        default: {
            lat:  47.373878,
            lng: 8.545094,
        }
    },
})

let geocoder = new google.maps.Geocoder();
let googleMap = null;
let marker = null;

onMounted(() => {
    const map_container = document.getElementById("map-container");
    const zurich = new google.maps.LatLng(props.defaultCenter);
    googleMap = new google.maps.Map(map_container, {
        center: zurich,
        zoom: 15,
        options: {
            gestureHandling: "greedy",
        },
    });

    //set market on click
    googleMap.addListener("click", (e) => {
        setMarker(e.latLng, googleMap);
    });

    //set initail marker if lat and lng is available
    // if (form.lat && form.lng) {
    //     const latLng = new google.maps.LatLng(form.lat, form.lng);
    //     geocoder.geocode({ location: latLng }).then((res) => {
    //         let location_type = res.results[0]?.geometry.location_type;
    //         if (location_type == "ROOFTOP" || location_type == "RANGE_INTERPOLATED")
    //             setMarker(latLng, googleMap, res.results[0]["formatted_address"]);
    //     });
    // }
});

watch(()=>props.center,
    (newVal, oldVal)=> {
        if(newVal.lat && newVal.lng) {
            setMarkerPosition(newVal)
            googleMap.setCenter(newVal);
        }
    },
    {deep: true}
)

// watch(
//     () => [form.lat, form.lng],
//     () => {
//         const latLng = new google.maps.LatLng(form.lat, form.lng);
//         setMarker(latLng, googleMap);
//     }
// );

//set marker on map and update the lattitude and lng value
const setMarker = async (position, map) => {
    setMarkerPosition(position)

    googleMap.setCenter(position);
    let res = await geocoder.geocode({ location: position });
    const address = getAddress(res.results[0]);
    emit('address_selected', address)
};

const setMarkerPosition = (position)=> {
    if (marker) {
        marker.setPosition(position);
    } else {
        marker = new google.maps.Marker({
            position: position,
            map: googleMap,
        });
    }
}

const getAddress = (event) => {
    const address = {
        lat: event.geometry.location.lat(),
        lng: event.geometry.location.lng(),
        street_name:  null,
        street_number: null,
        zip_code: null,
        city: null,
        country: null,
        formatted_address: event.formatted_address,
    }
    event.address_components.forEach(element => {
        if(element.types.includes('street_number')) {
            address.street_number = element.long_name
        }
        if(element.types.includes('route')) {
            address.street_name = element.long_name
        }
        if(element.types.includes('sublocality')) {
            address.city = element.long_name
        }
        if(element.types.includes('locality')) {
            address.city = element.long_name
        }
        if(element.types.includes('postal_code')) {
            address.zip_code = element.long_name
        }
        if(element.types.includes('country')) {
            address.country = element.short_name
        }
    });

    return address
}


</script>

<style lang="scss" scoped>

</style>
