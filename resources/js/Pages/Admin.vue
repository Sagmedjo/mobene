<template>
    <div class="overflow-x-auto">
        <table class="table w-full">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>E-Mail-Adresse</th>
                <th>Telefonnummer</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            <tr v-for="inquiry in energy_consultation_inquiries">
                <th>{{inquiry.id}}</th>
                <td>{{inquiry.first_name+' '+inquiry.last_name}}</td>
                <td>{{inquiry.email}}</td>
                <td>{{inquiry.phone}}</td>
                <td><label :for="'my-modal'+inquiry.id" class="btn">Details</label></td>
                <td><label :for="'my-modal'+inquiry.id+'a'" class="btn">KI Bullet List</label></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div v-for="inquiry in energy_consultation_inquiries">
        <input type="checkbox" :id="'my-modal'+inquiry.id" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <table class="table w-full">
                    <tr v-for="(attribute, key, index) in inquiry" v-if="key !== 'bullet_list'">
                        <th>
                            {{key.split('_').map(word => {return word.charAt(0).toUpperCase() + word.slice(1);}).join(' ')}}
                        </th>
                        <td>
                            {{attribute}}
                        </td>
                    </tr>
                </table>
                <div class="modal-action">
                    <label :for="'my-modal'+inquiry.id" class="btn">Close</label>
                </div>
            </div>
        </div>
        <input type="checkbox" :id="'my-modal'+inquiry.id+'a'" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <p v-html="inquiry.bullet_list"></p>
                <div class="modal-action">
                    <label :for="'my-modal'+inquiry.id+'a'" class="btn">Close</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    energy_consultation_inquiries: Array
})
</script>
