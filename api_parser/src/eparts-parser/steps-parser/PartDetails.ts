import {ParserHeaderConfigInterface} from "../config/ParserConfig";
import {AssemblyPartsDto} from "../dto/AssemblyPartsDto";
import {Axios} from "axios";
import {PartDetailsDto} from "../dto/PartDetailsDto";

interface PartDetailsInterface {
    attributes: any[];
    bigHeavy: boolean;//false
    dfs: boolean;//false
    dispoCode: string;//"0"
    epa: boolean;//false
    functionalDescription: string;//" "
    grossWeightKG: string;//"737.000000"
    grossWeightLB: string;//"1624.806872"
    hazardous: boolean;//false
    image: string;//"/9j/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMD
    localDescription: string;//" "
    localSubCode: string;//"6"
    mpc: string;//"21530"
    mpl: string;//"215"
    msds: boolean;//false
    packageQty: number;//1
    partClassification: string;//"J"
    partDescription: string;//"GEAR"
    partId: string;//"87802906"
    partType: string;//"2"
    pcc: string;//"P213F"
    returnable: boolean;//true
    skuGlobal: string;//"87802906"
    subCode: string;//"0"
    technicalDescription: string;//" "
}

export class PartDetails {

    static apiMethod = '/parts/details';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    async get(dto: PartDetailsDto): Promise<PartDetailsInterface> {

        let url = this.parserConfig.apiUrl + PartDetails.apiMethod;

        const urlRequest = new URL(url);
        urlRequest.searchParams.append("partId", String(dto.partId));
        urlRequest.searchParams.append("assemblyId", String(dto.assemblyId));
        urlRequest.searchParams.append("modelId", String(dto.modelId));


        let axios = new Axios({
            headers: {
                userId: this.parserConfig.header.userId,
                language: this.parserConfig.header.language,
                regionId: this.parserConfig.header.regionId,
                brandId: dto.brandId,
            }
        });

        let response = await axios.get(urlRequest.href);
        return JSON.parse(response.data);
    }

}