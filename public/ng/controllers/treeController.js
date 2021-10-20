function treeController($scope, $init) {
    const renderOne = (item) => {
        let o = `<li><div><span>${item.name}-${item.level}</span></div>`;
        if (item?.children?.length) {
            o += "<ol>";
            item.children.forEach((s) => (o += renderOne(s)));
            o += "</ol>";
        }
        o += "</li>";
        return o;
    };

    let json =
        "https://molhamteam.com/tree_generator.php?nodes=1,5,10,2,7,9";
    fetch(json)
        .then((json) => json.json())
        .then((res) => {
            let out = '<ol class="organizational-chart">';

            res.forEach((one) => {
                out += renderOne(one);
            });
            out += "</ol>";
            $("#orgTree").html(out);
        });
}
