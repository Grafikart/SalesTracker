import {
    RiBeerLine,
    RiBowlLine,
    RiBreadLine,
    RiCake3Line,
    RiCupLine,
    RiDrinks2Line,
} from "@remixicon/react";

const icons = {
    beer: RiBeerLine,
    bowl: RiBowlLine,
    bread: RiBreadLine,
    cake: RiCake3Line,
    cup: RiCupLine,
    drink: RiDrinks2Line,
};

export function ProductIcon(props: { icon: string; className?: string }) {
    // @ts-ignore Typescript cannot understand that icon is in icons keys
    const IconComponent = props.icon in icons ? icons[props.icon] : Bowl;
    return <IconComponent className={props.className} />;
}
