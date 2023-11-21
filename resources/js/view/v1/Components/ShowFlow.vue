<script setup>
import {computed, defineComponent, defineProps, onMounted, reactive, ref} from "vue";
import {useFlowStore} from "@/store/flow.js";
import Datatables from "@/view/v1/Components/datatables.vue";
import {VNetworkGraph} from "v-network-graph"
import "v-network-graph/lib/style.css"

const props=defineProps({
    data:{
        type:Object,
        default:{},
    }
})
const item=ref(props.data?.item);
const dialog=ref(false);
const flowStore=useFlowStore()
const flows = ref([]);

function getFlow(obj){
    flowStore.getFlowWithCode(obj)
        .then(response=>{
            flows.value = response.data;
            if (showType.value == 'graph') {
            Object.entries(flows.value).forEach(([i,row],index) => computeGraphData(row));
            }
        })
        .catch(error=>{
            console.error(error)
        })
        .finally(()=>{
            dialog.value=true;
        })
}

const page = ref(1);
const showType = ref('graph');

const graph=reactive({
    nodes:{},
    edges:{},
})
function computeGraphData(flow)
{
    // if (flow.StartNode){
    //     graph.nodes[`node_${flow.StartNode['@attributes']['RoleID']}-${flow.StartNode['@attributes']['ReceiverCode']?flow.StartNode['@attributes']['ReceiverCode']:'root'}`] = {name: `${flow.StartNode['@attributes']['FirstName']} ${flow.StartNode['@attributes']['LastName']}`};
    //     flow.StartNode.Node.forEach(row=>{
    //         debugger;
    //         console.log(row);
    //         graph.nodes[`node_${row['@attributes']['RoleID']}-${row['@attributes']['ReceiverCode']?row['@attributes']['ReceiverCode']:'root'}`] = {name: `${row['@attributes']['FirstName']} ${row['@attributes']['LastName']}`};
    //         graph.edges[`edges_${row['@attributes']['SendCode']}`] =
    //          {
    //              source: `node_${row['@attributes']['SenderRoleID']}-${row['@attributes']['ReceiverCode']?row['@attributes']['ReceiverCode']:'root'}`,
    //              target:`node_${row['@attributes']['RoleID']}-${row['@attributes']['ReceiverCode']?row['@attributes']['ReceiverCode']:'root'}`
    //          };
    //     })
    // }
    if (flow.StartNode){
        graph.nodes[`node_${flow.StartNode['@attributes']['RoleID']}`] = {name: `${flow.StartNode['@attributes']['FirstName']} ${flow.StartNode['@attributes']['LastName']}`};
        flow.StartNode.Node.forEach(row=>{
            debugger;
            console.log(row);
            graph.nodes[`node_${row['@attributes']['RoleID']}`] = {name: `${row['@attributes']['FirstName']} ${row['@attributes']['LastName']}`};
            graph.edges[`edges_${row['@attributes']['SendCode']}`] =
                {
                    source: `node_${row['@attributes']['SenderRoleID']}`,
                    target:`node_${row['@attributes']['RoleID']}`
                };
        })
    }
}
</script>
<template>
    <div class="text-center">
        <v-tooltip text="مشاهده گردش">
            <template v-slot:activator="{ props }">
                <v-btn v-bind="props"
                       :disabled="!item?.ec"
                       @click="getFlow(item)"
                       density="compact" size="small" icon>
                    <v-icon size="small">mdi-information-outline</v-icon>
                </v-btn>
            </template>
        </v-tooltip>

        <v-dialog
            v-model="dialog"
            min-width="250"
            min-height="250"
            width="auto"
        >
            <v-sheet>
                <pre dir="ltr">{{graph}}</pre>
                <datatables
                        v-if="showType=='table'"
                        :headers="[
                        {key:'FirstName',title:'نام'},
                        {key:'LastName',title:'نام خانوادگی'},
                        {key:'RoleName',title:'پست سازمانی'},
                        {key:'LastName',title:'نام خانوادگی'},
                    ]"
                                :total="flow.RecordCount"
                                :perPage="10"
                                v-model:page="page"
                                :headers-prepend="[
                                    {key:'subtrack',title:'نام'}
                                ]"
                                :items="flow" v-for="flow in flows"
                    >
                        <template v-slot:subtrack="{item}">
                            <pre dir="ltr">{{item.SendCode}}</pre>
                        </template>

                    </datatables>
                <v-network-graph v-if="showType=='graph'" :nodes="graph.nodes" :edges ="graph.edges "/>



                <v-btn prepend-icon="mdi-close" variant="elevated" color="error" @click="dialog = false">بستن پنجره</v-btn>

            </v-sheet>
        </v-dialog>
    </div>
</template>

<style scoped>

</style>
