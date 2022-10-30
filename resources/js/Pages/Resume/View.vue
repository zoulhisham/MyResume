<script setup>
    const props = defineProps({
        resume: Object,
    });

    function print()
    {
        window.print()
    }
</script>

<template>
    <div class="container mx-auto md:w-auto max-w-screen-lg">
        <main id="wrapper" class="flex flex-col sm:flex-row-reverse sm:m-12 shadow-2xl">
            <div class="content w-full p-12">
                <div>
                    <li class="flex py-4">
                        <div v-if="resume.data.personal_detail.profile_image_url" class="h-36 w-36 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            <img :src="resume.data.personal_detail.profile_image_url" alt="Profile photo" class="h-full w-full object-cover object-center">
                        </div>
                        <div class="ml-4 flex flex-1 flex-col">
                            <div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3 class="text-blue-600 text-xl font-black uppercase">{{ resume.data.personal_detail.first_name + ' ' + resume.data.personal_detail.last_name }}</h3>
                                    <div class="flex">
                                        <button @click="print" class="mr-4 font-medium text-blue-600 dark:text-blue-500">Print</button>
                                    </div>
                                </div>
                                <p class="mt-1 text-base text-gray-500 font-black">{{ resume.data.latest_job.position}} ( {{ resume.data.latest_job.duration }})</p>
                                <p class="mt-1 text-base text-gray-500 font-black uppercase">{{ resume.data.latest_job.company_name }}</p>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-sm">
                                    <div class="text-gray-500 text-base">
                                        <span class="flex-nowrap">{{ resume.data.personal_detail.phone_no }}</span>
                                            |
                                        <span class="flex-nowrap">{{ resume.data.personal_detail.email }}</span>
                                            |
                                        <span class="flex-nowrap">{{ resume.data.personal_detail.gender_name }}</span>
                                            |
                                        <span class="flex-nowrap">{{ resume.data.personal_detail.age }}</span>
                                            |
                                        <span class="flex-nowrap">{{ resume.data.personal_detail.country_name }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-500">
                                        {{ resume.data.personal_detail.address1 + ' ' + resume.data.personal_detail.address2 + ' ' + resume.data.personal_detail.postal_code + ' ' + resume.data.personal_detail.city }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-4">
                    <div class="border-t border-gray-200" />
                    </div>
                </div>

                <div>
                    <h2 class="my-4">Experience</h2>
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">                  
                        <li v-for="experience in resume.data.experiences" :key="experience.id" class="mb-10 ml-4">
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{experience.start_date_display }} - {{ experience.end_date_display}}</time>
                            <div class="text-sm font-semibold text-gray-900">{{ experience.company_name }} | {{ experience.city }}</div>
                            <div class="text-base font-bold text-gray-700">{{ experience.position }}</div>
                            <p class="mt-2 text-sm whitespace-pre">{{ experience.description }}</p>
                        </li>
                    </ol>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-4">
                    <div class="border-t border-gray-200" />
                    </div>
                </div>

                <div>
                    <h2 class="my-4">Education</h2>
                    <div v-for="education in resume.data.educations" :key="education.id" class="flex flex-col py-4">
                        <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{education.start_date_display }} - {{ education.end_date_display}}</time>
                        <div class="text-sm font-semibold text-gray-900">{{ education.school }} | {{ education.city }}</div>
                        <div class="text-base font-bold text-gray-700">{{ education.qualification }}</div>
                        <p class="mt-2 text-sm whitespace-pre">{{ education.description }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
