const Ziggy = {"url":"https:\/\/app.mobeneconnect.de","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"home":{"uri":"\/","methods":["GET","HEAD"]},"energieberatung.index":{"uri":"energieberatung","methods":["GET","HEAD"]},"energieberatung.create":{"uri":"energieberatung\/create","methods":["GET","HEAD"]},"energieberatung.store":{"uri":"energieberatung","methods":["POST"]},"energieberatung.show":{"uri":"energieberatung\/{energieberatung}","methods":["GET","HEAD"]},"energieberatung.edit":{"uri":"energieberatung\/{energieberatung}\/edit","methods":["GET","HEAD"]},"energieberatung.update":{"uri":"energieberatung\/{energieberatung}","methods":["PUT","PATCH"]},"energieberatung.destroy":{"uri":"energieberatung\/{energieberatung}","methods":["DELETE"]},"terminbuchung":{"uri":"terminbuchung","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
