<template>
    <main class="flex h-screen">
        <section class="max-w-5xl mr-auto ml-10 my-5 text-center px-12 py-10 hidden md:block">
            <img
                :src="$page.props.image"
                alt="Test"
                class="rounded-2xl"
            >
        </section>
        <section
            class="flex items-center justify-center w-6/12 max-w-5xl mx-auto md:ml-auto md:mr-10 my-5 text-center border-2 px-12 py-10 rounded-2xl shadow-lg">
            <a class="btn btn-lg btn-wide bg-sekundaer" href="https://calendly.com/mobeneconnect/energieberatung">Termin buchen!</a>
        </section>
    </main>
</template>

<script>
export default {
name: "Meeting"
}
</script>
