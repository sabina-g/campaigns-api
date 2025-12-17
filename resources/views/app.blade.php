<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Aktive Kampagnen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
</head>
<body>
<div class="container mt-4" id="app"></div>

<script>
    const {useState, useEffect} = React;

    function ActiveCampaignList() {
        const [campaigns, setCampaigns] = useState([]);
        const [offset, setOffset] = useState(0);
        const [loading, setLoading] = useState(false);
        const [error, setError] = useState(null);
        const LIMIT = 10;

        useEffect(() => {
            setLoading(true);
            setError(null);
            fetch('/api/campaigns/active-paginated?limit=' + LIMIT + '&offset=' + offset)
                .then(r => r.ok ? r.json() : Promise.reject('Fehler beim Laden'))
                .then(j => setCampaigns(j.data))
                .catch(e => setError(e))
                .finally(() => setLoading(false));
        }, [offset]);

        if (loading) return React.createElement('p', {className: 'text-center mt-3'}, 'Lade...');
        if (error) return React.createElement('p', {className: 'text-danger text-center mt-3'}, error);

        return React.createElement('div', null,
            React.createElement('h2', {className: 'mb-3'}, 'Aktive Kampagnen'),
            campaigns.length === 0
                ? React.createElement('p', null, 'Keine Kampagnen gefunden.')
                : React.createElement('div', {className: 'list-group mb-3'},
                    campaigns.map(c =>
                        React.createElement('div', {
                                key: c.id,
                                className: 'list-group-item'
                            },
                            c.name + ' (' + c.starts_at + ' – ' + c.ends_at + ')'
                        )
                    )
                ),
            React.createElement('div', {className: 'mt-3'},
                React.createElement('button', {
                    onClick: () => setOffset(prev => Math.max(0, prev - LIMIT)),
                    disabled: offset === 0,
                    className: 'btn btn-primary me-2'
                }, 'Zurück'),
                React.createElement('button', {
                    onClick: () => setOffset(prev => prev + LIMIT),
                    className: 'btn btn-primary'
                }, 'Weiter')
            )
        );
    }

    ReactDOM.createRoot(document.getElementById('app')).render(React.createElement(ActiveCampaignList));
</script>
</body>
</html>
