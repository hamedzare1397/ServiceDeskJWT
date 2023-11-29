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

    function getTime(){
        api.get('time')
            .then(response=>{
                if (response.status == 200) {
                    timeStampFull.value = response.data;
                    setInterval(startTime, 1000);
                }
            });
    }

    onMounted(()=>{
        getTime()
    })
    function startTime(){
        timeStampFull.value+=1000

        // const date =
        //     current.getFullYear() +
        //     "-" +
        //     (current.getMonth() + 1) +
        //     "-" +
        //     current.getDate();
        // const time =
        //     current.getHours() +
        //     ":" +
        //     current.getMinutes() +
        //     ":" +
        //     current.getSeconds();
        // showTime.value = date + " " + time;
    }

    watch(timeStampFull,(newVal,oldVal)=>{
        const tim = new Date(newVal);
        h.value = tim.getHours();
        m.value = tim.getMinutes();
        s.value = tim.getSeconds();
        console.log(h,m.s);
    })
    return {h,m,s}
}


</script>
