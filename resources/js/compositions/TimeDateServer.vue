<script>
import {onMounted, ref, watch} from 'vue'
import {useApi} from './CallApi.vue';


export async function useGetTime()
{
    const api = useApi();
    const timeStampFull = ref(null);
    const h = ref(0);
    const m = ref(0);
    const s = ref(0);
    api.get('time')
        .then(response=>{
            if (response.status == 200) {
                timeStampFull.value = Number(response.data)* 1000;
                setInterval(startTime, 1000);
            }
        });

    function startTime(){
        timeStampFull.value += 1000;
    }

    watch(timeStampFull,(newVal)=>{
        const tim = new Date(newVal);
        h.value = tim.getHours();
        m.value = tim.getMinutes();
        s.value = tim.getSeconds();
    })
    return {h,m,s}
}


</script>
