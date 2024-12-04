import { definePreset } from "@primevue/themes";
import Nora from '@primevue/themes/nora'

export const RotcPresets = definePreset(Nora, {
    semantic: {
        primary: {
            50: '{green.50}',
            100: '{green.100}',
            200: '{green.200}',
            300: '{green.300}',
            400: '{green.400}',
            500: '{green.500}',
            600: '{green.600}',
            700: '{green.700}',
            800: '{green.800}',
            900: '{green.900}',
            950: '{green.950}'
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{lime.950}',
                    inverseColor: '#ffffff',
                    hoverColor: '{lime.900}',
                    activeColor: '{lime.800}'
                },
                highlight: {
                    background: '{lime.950}',
                    focusBackground: '{lime.700}',
                    color: '#ffffff',
                    focusColor: '#ffffff'
                }
            },
            dark: {
                primary: {
                    color: '{lime.50}',
                    inverseColor: '{lime.950}',
                    hoverColor: '{lime.100}',
                    activeColor: '{lime.200}'
                },
                highlight: {
                    background: 'rgba(250, 250, 250, .16)',
                    focusBackground: 'rgba(250, 250, 250, .24)',
                    color: 'rgba(255,255,255,.87)',
                    focusColor: 'rgba(255,255,255,.87)'
                }
            }
        }
    }
});