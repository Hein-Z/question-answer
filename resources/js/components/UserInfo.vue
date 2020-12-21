<template>
    <div class=" ml-1 row">
        <div class="d-flex ">
            <img :src="model.user.gravator" alt="avator" class="img-thumbnail " width="50px"
                 height="50px">
        </div>
        <div class=' ml-2 d-flex flex-column justify-content-around'>
            <div class=" h5 text-info mb-0 ">{{ label }} By - <span
                class="text-black-50">{{ model.user.name }}</span></div>
            <small class="text-info ">Date - <span
                class="text-black-50">{{ model.created_date }}</span></small>
        </div>
    </div>
</template>

<script>
export default {
    props: ['model', 'label'],
    created() {

    }
}
</script>
