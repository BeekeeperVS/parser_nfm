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

@Controller('eparts-parser')
export class EpartsParserController {

    @Post('brands')
    async test(@Body() brandDto: BrandDto, @Res() res: Response) {
            let brands = new Brands(parserConfig());
            let brandsList = await brands.get(brandDto);
            res.send({status: true, brands: brandsList});

        return true;
    }

    @Post('product-types')
    async productTypes(@Body() productTypeDto: ProductTypeDto, @Res() res: Response) {
        let productTypes = new ProductTypes(parserConfig());
        let productTypesList = await productTypes.get(productTypeDto);
        res.send({status: true, productTypes: productTypesList});

        return true;
    }

    @Post('product-lines')
    async productLines(@Body() productLineDto: ProductLineDto, @Res() res: Response) {
        let productLines = new ProductLines(parserConfig());
        let productTypesList = await productLines.get(productLineDto);
        res.send({status: true, productLines: productTypesList});
        return true;
    }


    @Post('product-series')
    async productSeries(@Body() productSeriesDto: ProductSeriesDto, @Res() res: Response) {
        let productSeries = new ProductLines(parserConfig());
        let productSeriesList = await productSeries.get(productSeriesDto);
        res.send({status: true, productSeries: productSeriesList});
        return true;
    }

}
