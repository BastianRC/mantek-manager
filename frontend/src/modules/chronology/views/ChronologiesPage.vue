<template>
    <LoadingScreen :visible="isFetching || isFetching" />

    <HeaderComponent title="Historial Cronologico de Acciones" subtitle="Supervisa todos las acciones realizadas por los usuarios">
        <template v-slot:buttons>
            <Button @click="refetch">
                <RefreshCcw class="mr-0 size-4" />
                <span class="hidden md:block">Refrescar</span>
            </Button>
        </template>
    </HeaderComponent>

    <div class="container mx-auto p-6">
        <Card>
            <CardTitle class="px-6">
                Historial Completo
            </CardTitle>
            <CardContent>
                <ChronologyList v-if="chronologies" :chronologies="chronologies" />
            </CardContent>
        </Card>
    </div>
</template>

<script setup lang="ts">
import LoadingScreen from '~/components/custom/Loading/LoadingScreen.vue';
import ChronologyList from '../components/ChronologyList.vue';
import { useGetChronologiesList } from '../composables/useGetChronologiesList';
import HeaderComponent from '~/components/custom/Header/HeaderComponent.vue';
import Button from '~/components/ui/button/Button.vue';
import { RefreshCcw } from 'lucide-vue-next';
import Card from '~/components/ui/card/Card.vue';
import CardTitle from '~/components/ui/card/CardTitle.vue';
import CardContent from '~/components/ui/card/CardContent.vue';

const { data: chronologies, isFetching: isFetching, suspense: suspense, refetch } = useGetChronologiesList()

onServerPrefetch(async () => {
    await suspense()
})

</script>

<style scoped></style>