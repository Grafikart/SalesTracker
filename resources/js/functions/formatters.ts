const dateFormatter = new Intl.DateTimeFormat(undefined, {
    timeStyle: "short",
});
const priceFormatter = new Intl.NumberFormat(undefined, {
    style: "currency",
    currency: "EUR",
});

export function priceFormat(price: number) {
    return priceFormatter.format(price);
}

export function hourFormat(date: string | Date) {
    const d = typeof date === "string" ? Date.parse(date) : date;
    return dateFormatter.format(d);
}
