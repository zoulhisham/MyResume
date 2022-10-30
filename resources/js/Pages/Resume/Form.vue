<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import '@vuepic/vue-datepicker/dist/main.css';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import { computed, ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon } from '@heroicons/vue/20/solid'

const props = defineProps({
  genderList: Array,
  countries: Array,
  title: String,
  errors: Object,
  resume: Object,
  states: Array,
  action: String
});

const states = ref(props.states ? props.states : [])

const processing = ref(false)

const resume = ref({
    name: props.resume?.data.name ? props.resume.data.name : ''
})

const personal = ref({
    first_name: props.resume?.data.personal_detail ? props.resume.data.personal_detail.first_name : '',
    last_name: props.resume?.data.personal_detail ? props.resume.data.personal_detail.last_name : '',
    email: props.resume?.data.personal_detail ? props.resume.data.personal_detail.email : '',
    phone_no: props.resume?.data.personal_detail ? props.resume.data.personal_detail.phone_no : '',
    birth_date: props.resume?.data.personal_detail ? props.resume.data.personal_detail.birth_date : '',
    gender: props.resume?.data.personal_detail ? props.resume.data.personal_detail.gender : '',
    address1: props.resume?.data.personal_detail ? props.resume.data.personal_detail.address1 : '',
    address2: props.resume?.data.personal_detail ? props.resume.data.personal_detail.address2 : '',
    postal_code: props.resume?.data.personal_detail ? props.resume.data.personal_detail.postal_code : '',
    city: props.resume?.data.personal_detail ? props.resume.data.personal_detail.city : '',
    state_id: props.resume?.data.personal_detail ? props.resume.data.personal_detail.state_id : '',
    country_id: props.resume?.data.personal_detail ? props.resume.data.personal_detail.country_id : '',
    profile_image: ''
})

const profile_image_url = ref(props.resume?.data.personal_detail ? props.resume?.data.personal_detail.profile_image_url : '')

const experiencesArray = ref(getExperiences())

const educationsArray = ref(getEducations())

const fileErrorMessage = ref([])

const submit = () => {
    let data = {
        ...resume.value,
        ...personal.value,
        experiences: experiencesArray.value,
        educations: educationsArray.value,
    }

    const form = useForm(data)
    switch(props.action) {
        case 'create':
            form.post(route('resumes.store'), {
                onStart: () => { processing.value = true },
                onFinish: () => { processing.value = false },
            });
        break;
        case 'edit':
            form.post(route('resumes.update', props.resume?.data.id), {
                onStart: () => { processing.value = true },
                onFinish: () => { processing.value = false },
                _method: 'put'
            });
        break;
    }
};

const uploadForm = useForm({
    file: '',
    id: null
})

function onFileChange(e) {
    const file = e.target.files[0];

    let typeArr = file.type.split('/');
    let type = typeArr[0]

    console.log(type)

    if(type != 'image') {
        props.errors.profile_image = 'The file is not an image'
        return;
    }

    personal.value.profile_image = file
    profile_image_url.value = URL.createObjectURL(file)
}

function getExperiences()
{
    let data = [
        {
            position: '',
            company_name: '',
            start_date: '',
            end_date: '',
            is_present: false,
            city: '',
            description: '',
        }
    ]

    if(props.resume?.data.experiences) {
        data = []
        props.resume.data.experiences.forEach((val) => {
            data.push({
                id: val.id,
                position: val.position,
                company_name: val.company_name,
                start_date: val.start_date,
                end_date: val.end_date,
                is_present: val.is_present,
                city: val.city,
                description: val.description,
            })
        })
    }
    
    return data
}

function addExperiences()
{
    experiencesArray.value.push({
        position: '',
        company_name: '',
        start_date: '',
        end_date: '',
        is_present: false,
        city: '',
        description: '',
    })
}

function removeExperiences(index)
{
    experiencesArray.value.splice(index, 1);
}

function getEducations()
{
    let data = [
        {
            school: '',
            qualification: '',
            start_date: '',
            end_date: '',
            is_present: false,
            city: '',
            description: ''
        }
    ]

    if(props.resume?.data.educations) {
        data = []
        props.resume.data.educations.forEach((val) => {
            data.push( {
                id: val.id,
                school: val.school,
                qualification: val.qualification,
                start_date: val.start_date,
                end_date: val.end_date,
                is_present: val.is_present,
                city: val.city,
                description: val.description
            })
        })
    }
    
    return data
}

function addEducations()
{
    educationsArray.value.push({
        school: '',
        qualification: '',
        start_date: '',
        end_date: '',
        is_present: false,
        city: '',
        description: ''
    })
}

function removeEducations(index)
{
    educationsArray.value.splice(index, 1);
}

function getState(id) 
{
    axios.get(route('states.list'), {
        params: {
            country_id: id
        }
    })
    .then(res => {
        states.value = res.data
    })
}

function removeImage()
{
    profile_image_url.value = null
    personal.value.profile_image = null
}
</script>

<template>
    <Head :title="title + ' Your Resume'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }} Your Resume
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div v-if="fileErrorMessage.length > 0" class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Ensure that these requirements are met:</span>
                    <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                        <li v-for="(val, index) in fileErrorMessage" :key="index">{{ val }}</li>
                    </ul>
                </div>
            </div>
            <form @submit.prevent="submit">
                <!-- <div class="bg-gray-300	p-6 mb-4 text-center text-gray-700">{{ resume?.name }}</div> -->
                <div class="flex items-center justify-center bg-gray-100 p-4 mb-4">
                    <div class="mx-auto w-full max-w-xs">
                        <div class="relative z-0">
                            <input v-model="resume.name" type="text" id="resume_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="resume_name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Resume Name</label>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="overflow-hidden shadow sm:rounded-md">
                                <div class="bg-white px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="first_name" value="First Name" />
                                            <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="personal.first_name" />
                                            <InputError class="mt-2" :message="errors.first_name" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="last_name" value="Last Name" />
                                            <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="personal.last_name"  />
                                            <InputError class="mt-2" :message="errors.last_name" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="email" value="Email" />
                                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="personal.email"  />
                                            <InputError class="mt-2" :message="errors.email" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="phone_no" value="Phone no" />
                                            <TextInput id="phone_no" type="text" class="mt-1 block w-full" v-model="personal.phone_no"  />
                                            <InputError class="mt-2" :message="errors.phone_no" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="birth_date" value="Date of birth" />
                                            <Datepicker class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="personal.birth_date" :enableTimePicker="false" autoApply :maxDate="new Date()" format="dd/MM/yyyy"></Datepicker>
                                            <InputError class="mt-2" :message="errors.birth_date" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="gender" value="Gender" />
                                            <div class="flex mt-4">
                                                <div class="flex items-center mr-4" :key="val.id" v-for="val in genderList">
                                                    <input type="radio" name="gender" v-model="personal.gender" :id="'gender' + val.id" :value="val.id" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                    <label :for="'gender' + index" class="ml-3 block text-sm font-medium text-gray-700">{{val.name}}</label>
                                                </div>
                                            </div>
                                            <InputError class="mt-2" :message="errors.gender" />
                                        </div>
                                        <div class="col-span-6">
                                            <InputLabel for="address1" value="Address 1" />
                                            <TextInput id="address1" type="text" class="mt-1 block w-full" v-model="personal.address1"  />
                                            <InputError class="mt-2" :message="errors.email" />
                                        </div>
                                        <div class="col-span-6">
                                            <InputLabel for="address2" value="Address 2" />
                                            <TextInput id="address2" type="text" class="mt-1 block w-full" v-model="personal.address2"  />
                                            <InputError class="mt-2" :message="errors.address2" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="postal_code" value="Postal Code" />
                                            <TextInput id="postal_code" type="text" class="mt-1 block w-full" v-model="personal.postal_code"  />
                                            <InputError class="mt-2" :message="errors.postal_code" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="city" value="City" />
                                            <TextInput id="city" type="text" class="mt-1 block w-full" v-model="personal.city"  />
                                            <InputError class="mt-2" :message="errors.city" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="country_id" value="Country" />
                                            <Select name="country_id" @change="getState(personal.country_id)" :items="countries" v-model="personal.country_id"></Select>
                                            <InputError class="mt-2" :message="errors.country_id" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <InputLabel for="state" value="State" />
                                            <Select name="state_id" :items="states" v-model="personal.state_id"></Select>
                                            <InputError class="mt-2" :message="errors.state_id" />
                                        </div>
                                        <div class="col-span-6">
                                            <InputLabel for="profile_image" value="Profile Image" />
                                            <div>
                                                <div v-if="profile_image_url" class="flex">
                                                    <div class="h-36 w-36 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                        <img :src="profile_image_url" alt="Profile Image" class="h-full w-full object-cover object-center">
                                                    </div>
                                                    <div>
                                                        <button type="button" @click="removeImage" class="ml-4 font-medium text-blue-600 dark:text-blue-500">Remove</button>
                                                    </div>
                                                </div>
                                                <div v-else class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                                <span>Upload a file</span>
                                                                <input @input="photo = $event.target.files[0]" @change="onFileChange" id="file-upload" name="file-upload" type="file" class="sr-only" />
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 20KB</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <InputError class="mt-2" :message="errors.profile_image" />
                                            <!-- <progress v-if="uploadForm.progress" :value="uploadForm.progress.percentage" max="100">
                                                {{ uploadForm.progress.percentage }}%
                                            </progress> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-5">
                    <div class="border-t border-gray-200" />
                    </div>
                </div>

                <div class="mt-10 sm:mt-0">
                    <div v-for="(experience, index) in experiencesArray" :key="index"  class="mb-4 md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 v-if="index == 0" class="text-lg font-medium leading-6 text-gray-900">Work Experience</h3>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div  class="overflow-hidden shadow sm:rounded-md mt-2">
                                <Disclosure as="div" class="border-b border-gray-200 bg-gray-50 py-6" v-slot="{ open }">
                                    <h3 class="-my-5 flow-root">
                                        <DisclosureButton class="flex w-full items-center justify-between bg-gray-50 py-3 text-sm text-gray-400 hover:text-gray-500">
                                            <span class="ml-6 flex items-center">
                                                <PlusIcon v-if="!open && !errors[`experiences`]" class="h-5 w-5" aria-hidden="true" />
                                                <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                            </span>
                                            <button v-if="index != 0" type="button" class="mr-6 text-gray-400 hover:text-gray-500" @click="removeExperiences(index)">
                                                <span class="sr-only">Close</span>
                                                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                            </button>
                                        </DisclosureButton>
                                    </h3>
                                    <div v-show="!open">
                                        <DisclosurePanel class="pt-6" static>
                                            <div class="bg-white px-4 py-5 sm:p-6">
                                                <div class="grid grid-cols-6 gap-6">
                                                    <div class="col-span-6">
                                                        <InputLabel for="position" value="Position" />
                                                        <TextInput id="position" type="text" class="mt-1 block w-full" v-model="experience.position" />
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.position`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3">
                                                        <InputLabel for="company_name" value="Company Name" />
                                                        <TextInput id="company_name" type="text" class="mt-1 block w-full" v-model="experience.company_name"  />
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.company_name`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3">
                                                        <InputLabel for="city" value="City" />
                                                        <TextInput id="city" type="text" class="mt-1 block w-full" v-model="experience.city"  />
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.city`]" />
                                                    </div>
                                                    <div class="col-span-4 sm:col-span-2">
                                                        <InputLabel for="start_date" value="Start Date" />
                                                        <Datepicker class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="experience.start_date" :enableTimePicker="false" autoApply format="MM/yyyy" monthPicker></Datepicker>
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.start_date`]" />
                                                    </div>
                                                    <div class="col-span-4 sm:col-span-2">
                                                        <InputLabel for="end_date" value="End Date" />
                                                        <Datepicker class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="experience.end_date" :enableTimePicker="false" autoApply format="MM/yyyy" :disabled="experience.is_present" monthPicker></Datepicker>
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.end_date`]" />
                                                    </div>
                                                    <div class="col-span-2 sm:col-span-1">
                                                        <div class="block mt-8">
                                                            <label class="flex">
                                                                <Checkbox :id="'experience_is_present_' + index" name="is_present" v-model:checked="experience.is_present" />
                                                                <span class="ml-2 text-sm text-gray-600">Present</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-6">
                                                        <InputLabel for="description" value="Description" />
                                                            <textarea v-model="experience.description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm" placeholder="Develop REST API using PHP/Laravel" />
                                                        <InputError class="mt-2" :message="errors[`experiences.${index}.description`]" />
                                                    </div>
                                                </div>
                                            </div>
                                    </DisclosurePanel>
                                    </div>
                                </Disclosure>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end m-2">
                        <PrimaryButton @click="addExperiences" class="ml-4" type="button">
                            + Add Experience
                        </PrimaryButton>
                    </div>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-2">
                    <div class="border-t border-gray-200" />
                    </div>
                </div>

                <div class="mt-10 sm:mt-0">
                    <div v-for="(education, index) in educationsArray" :key="index"  class="mb-4 md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 v-if="index == 0" class="text-lg font-medium leading-6 text-gray-900">Education</h3>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div  class="overflow-hidden shadow sm:rounded-md">
                                <Disclosure as="div" class="border-b border-gray-200 bg-gray-50 py-6" v-slot="{ open }">
                                    <h3 class="-my-5 flow-root">
                                        <DisclosureButton class="flex w-full items-center justify-between bg-gray-50 py-3 text-sm text-gray-400 hover:text-gray-500">
                                            <span class="ml-6 flex items-center">
                                                <PlusIcon v-if="!open && !errors[`experiences`]" class="h-5 w-5" aria-hidden="true" />
                                                <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                            </span>
                                            <button v-if="index != 0" type="button" class="mr-6 text-gray-400 hover:text-gray-500" @click="removeEducations(index)">
                                                <span class="sr-only">Close</span>
                                                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                            </button>
                                        </DisclosureButton>
                                    </h3>
                                    <div v-show="!open">
                                        <DisclosurePanel class="pt-6" static>
                                            <div class="bg-white px-4 py-5 sm:p-6">
                                                <div class="grid grid-cols-6 gap-6">
                                                    <div class="col-span-6">
                                                        <InputLabel for="school" value="School" />
                                                        <TextInput id="school" type="text" class="mt-1 block w-full" v-model="education.school"  />
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.school`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3">
                                                        <InputLabel for="qualification" value="Qualification" />
                                                        <TextInput id="qualification" type="text" class="mt-1 block w-full" v-model="education.qualification"  />
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.qualification`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3">
                                                        <InputLabel for="city" value="City" />
                                                        <TextInput id="city" type="text" class="mt-1 block w-full" v-model="education.city"  />
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.city`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                        <InputLabel for="start_date" value="Start Date" />
                                                        <Datepicker class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="education.start_date" :enableTimePicker="false" autoApply format="MM/yyyy" monthPicker></Datepicker>
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.start_date`]" />
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                        <InputLabel for="end_date" value="End Date" />
                                                        <Datepicker class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="education.end_date" :enableTimePicker="false" autoApply format="MM/yyyy" :disabled="education.is_present ? true : false" monthPicker></Datepicker>
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.end_date`]" />
                                                    </div>
                                                    <div class="col-span-2 sm:col-span-1">
                                                        <div class="block mt-8">
                                                            <label class="flex">
                                                                <Checkbox :id="'education_is_present_' + index" name="is_present" v-model:checked="education.is_present" />
                                                                <span class="ml-2 text-sm text-gray-600">Present</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-6">
                                                        <InputLabel for="description" value="Description" />
                                                        <textarea v-model="education.description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm" placeholder="Grade A/1st Class" />
                                                        <InputError class="mt-2" :message="errors[`educations.${index}.description`]" />
                                                    </div>
                                                </div>
                                            </div>
                                        </DisclosurePanel>
                                    </div>
                                </Disclosure>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end m-2">
                        <PrimaryButton @click="addEducations" class="ml-4" type="button">
                            + Add Education
                        </PrimaryButton>
                    </div>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-2">
                    <div class="border-t border-gray-200" />
                    </div>
                </div>

                <div class="flex items-center justify-end m-2">
                    <PrimaryButton class="bg-indigo-500 ml-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>