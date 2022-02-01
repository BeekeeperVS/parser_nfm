import {Body, Controller, Post, Res} from '@nestjs/common';
import {Response} from "express";
import {BrandDto} from "./dto/BrandDto";
import {Brands} from "./steps-parser/Brands";
import {parserConfig} from "./config/ParserConfig"
import {ProductTypes} from "./steps-parser/ProductTypes";
import {ProductLines} from "./steps-parser/ProductLines";
import {ProductLineDto} from "./dto/ProductLineDto";
import {ProductTypeDto} from "./dto/ProductTypeDto";
import {ProductSeries} from "./steps-parser/ProductSeries";
import {ProductSeriesDto} from "./dto/ProductSeriesDto";
import {ProductModelDto} from "./dto/ProductModelDto";
import {ProductModels} from "./steps-parser/ProductModels";
import {EpartsParserService} from "./eparts-parser.service";
import {FunctionalGroupDto} from "./dto/FunctionalGroupDto";
import {FunctionalGroups} from "./steps-parser/FunctionalGroups";
import {AssemblyDto} from "./dto/AssemblyDto";
import {Assemblies} from "./steps-parser/Assemblies";
import {AssemblyDetailsDto} from "./dto/AsseblyDetailsDto";
import {AssemblyDetails} from "./steps-parser/AssemblyDetails";
import {AssemblyPartsDto} from "./dto/AssemblyPartsDto";
import {AssemblyParts} from "./steps-parser/AssemblyParts";
import {PartDetailsDto} from "./dto/PartDetailsDto";
import {PartDetails} from "./steps-parser/PartDetails";
import {PartSubstitutionsDto} from "./dto/PartSubstitutions";
import {PartsSubstitutions} from "./steps-parser/PartSubstitutions";
import {PartKitsDto} from "./dto/PartKitsDto";
import {PartKits} from "./steps-parser/PartKits";

@Controller('eparts-parser')
export class EpartsParserController {

    constructor(private readonly epartsParserService: EpartsParserService) {}

    @Post('brands')
    async brands(@Body() brandDto: BrandDto, @Res() res: Response) {
            let stepModel = new Brands(parserConfig());
            let brands = await stepModel.get(brandDto);
            res.send({status: true, brands: brands});

        return true;
    }

    @Post('product-types')
    async productTypes(@Body() productTypeDto: ProductTypeDto, @Res() res: Response) {
        let stepModel = new ProductTypes(parserConfig());
        let productTypes = await stepModel.get(productTypeDto);
        console.log(productTypeDto.brandId);
        res.send({status: true, productTypes: productTypes});

        return true;
    }

    @Post('product-lines')
    async productLines(@Body() productLineDto: ProductLineDto, @Res() res: Response) {
        let stepModel = new ProductLines(parserConfig());
        let productTypes = await stepModel.get(productLineDto);
        res.send({status: true, productLines: productTypes});
        return true;
    }

    @Post('product-series')
    async productSeries(@Body() productSeriesDto: ProductSeriesDto, @Res() res: Response) {
        let stepModel = new ProductSeries(parserConfig());
        let productSeries = await stepModel.get(productSeriesDto);
        res.send({status: true, productSeries: productSeries});
        return true;
    }

    @Post('product-models')
    async productModels(@Body() productModelsDto: ProductModelDto, @Res() res: Response) {
        let stepModel = new ProductModels(parserConfig());
        let productModels = await stepModel.get(productModelsDto);
        res.send({status: true, productModels: productModels});
        return true;
    }

    @Post('model-functional-groups')
    async modelFunctionalGroups(@Body() functionalGroupDto: FunctionalGroupDto, @Res() res: Response) {
        let stepModel = new FunctionalGroups(parserConfig());
        let functionalGroups = await stepModel.get(functionalGroupDto);
        res.send({status: true, functionalGroups: functionalGroups});
        return true;
    }

    @Post('model-assemblies')
    async modelAssemblies(@Body() assemblyDto: AssemblyDto, @Res() res: Response) {
        let stepModel = new Assemblies(parserConfig());
        let assemblies = await stepModel.get(assemblyDto);
        res.send({status: true, assemblies: assemblies});
        return true;
    }

    @Post('assembly-details')
    async assemblyDetails(@Body() assemblyDetailsDto: AssemblyDetailsDto, @Res() res: Response) {
        let stepModel = new AssemblyDetails(parserConfig());
        let assemblyDetails = await stepModel.get(assemblyDetailsDto);
        res.send({status: true, assemblyDetails: assemblyDetails});
        return true;
    }

    @Post('assembly-parts')
    async assemblyParts(@Body() assemblyPartsDto: AssemblyPartsDto, @Res() res: Response) {
        let stepModel = new AssemblyParts(parserConfig());
        let assemblyParts = await stepModel.get(assemblyPartsDto);
        res.send({status: true, assemblyParts: assemblyParts.parts});
        return true;
    }

    @Post('part-details')
    async partDetails(@Body() apartDetailsDto: PartDetailsDto, @Res() res: Response) {
        let stepModel = new PartDetails(parserConfig());
        let partDetails = await stepModel.get(apartDetailsDto);
        res.send({status: true, partDetails: partDetails});
        return true;
    }

    @Post('part-substitution')
    async partSubstitution(@Body() partSubstitutionDto: PartSubstitutionsDto, @Res() res: Response) {
        let stepModel = new PartsSubstitutions(parserConfig());
        let partSubstitution = await stepModel.get(partSubstitutionDto);
        res.send({status: true, partSubstitution: partSubstitution});
        return true;
    }

    @Post('part-kits')
    async partKits(@Body() partKitsDto: PartKitsDto, @Res() res: Response) {
        let stepModel = new PartKits(parserConfig());
        let partKits = await stepModel.get(partKitsDto);
        res.send({status: true, partKits: partKits});
        return true;
    }

}
